<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeInstallment extends Model
{
    protected $fillable = [
        'admission_id',
        'student_id',
        'installment_number',
        'title',
        'due_date',
        'amount',
        'paid_amount',
        'balance',
        'status',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'installment_number' => 'integer',
    ];

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function recalculate(): void
    {
        $this->paid_amount = $this->payments()->where('status', 'completed')->sum('amount');
        $this->balance = max(0, $this->amount - $this->paid_amount);

        if ($this->balance <= 0 && $this->amount > 0) {
            $this->status = 'Paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'Partially Paid';
        } else {
            $this->status = ($this->due_date && $this->due_date < now()->toDateString()) ? 'Overdue' : 'Pending';
        }

        $this->save();
    }
}
