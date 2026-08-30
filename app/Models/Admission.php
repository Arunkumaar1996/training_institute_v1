<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admission_number',
        'student_id',
        'course_id',
        'batch_id',
        'trainer_id',
        'admission_date',
        'course_fee',
        'discount',
        'final_fee',
        'total_paid',
        'balance',
        'due_date',
        'payment_status',
        'admission_status',
        'source',
        'referral_by',
        'remarks',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'due_date' => 'date',
        'course_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_fee' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function ($admission) {
            if (empty($admission->final_fee)) {
                $admission->final_fee = max(0, ($admission->course_fee ?? 0) - ($admission->discount ?? 0));
            }
            if ($admission->balance === null) {
                $admission->balance = max(0, $admission->final_fee - ($admission->total_paid ?? 0));
            }
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(FeeInstallment::class)->orderBy('installment_number');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->orderByDesc('payment_date');
    }

    public function recalculateTotals(): void
    {
        $this->final_fee = max(0, $this->course_fee - $this->discount);
        $this->total_paid = $this->payments()->where('status', 'completed')->sum('amount');
        $this->balance = max(0, $this->final_fee - $this->total_paid);

        if ($this->balance <= 0 && $this->final_fee > 0) {
            $this->payment_status = 'Paid';
        } elseif ($this->total_paid > 0) {
            $this->payment_status = 'Partially Paid';
        } else {
            $this->payment_status = ($this->due_date && $this->due_date < now()->toDateString()) ? 'Overdue' : 'Pending';
        }

        $this->save();
    }
}
