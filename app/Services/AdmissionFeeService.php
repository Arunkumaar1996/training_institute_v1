<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Admission;
use App\Models\FeeInstallment;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdmissionFeeService
{
    /**
     * Create student admission with fee calculations and installments
     */
    public function createAdmission(array $data): Admission
    {
        return DB::transaction(function () use ($data) {
            $prefix = Setting::get('admission_prefix', 'ADM-');
            $year = date('Y');
            $count = Admission::whereYear('created_at', $year)->count() + 1;
            $admissionNumber = sprintf('%s%s-%04d', $prefix, $year, $count);

            $courseFee = (float) ($data['course_fee'] ?? 0);
            $discount = (float) ($data['discount'] ?? 0);
            $finalFee = max(0, $courseFee - $discount);
            $initialPayment = (float) ($data['initial_payment'] ?? 0);

            if ($initialPayment > $finalFee) {
                throw new Exception("Initial payment amount ({$initialPayment}) cannot exceed the final fee ({$finalFee}).");
            }

            $admission = Admission::create([
                'admission_number' => $admissionNumber,
                'student_id' => $data['student_id'],
                'course_id' => $data['course_id'],
                'batch_id' => $data['batch_id'] ?? null,
                'trainer_id' => $data['trainer_id'] ?? null,
                'admission_date' => $data['admission_date'] ?? now()->toDateString(),
                'course_fee' => $courseFee,
                'discount' => $discount,
                'final_fee' => $finalFee,
                'total_paid' => 0,
                'balance' => $finalFee,
                'due_date' => $data['due_date'] ?? null,
                'payment_status' => 'Pending',
                'admission_status' => 'Active',
                'source' => $data['source'] ?? 'Website',
                'referral_by' => $data['referral_by'] ?? null,
                'remarks' => $data['remarks'] ?? null,
            ]);

            // If batch assigned, link student to batch
            if (!empty($data['batch_id'])) {
                DB::table('batch_student')->updateOrInsert(
                    ['batch_id' => $data['batch_id'], 'student_id' => $data['student_id']],
                    ['assigned_date' => now()->toDateString(), 'status' => 'active', 'updated_at' => now()]
                );
            }

            // Create installments if specified
            if (!empty($data['installments']) && is_array($data['installments'])) {
                foreach ($data['installments'] as $index => $inst) {
                    $instAmount = (float) ($inst['amount'] ?? 0);
                    if ($instAmount > 0) {
                        FeeInstallment::create([
                            'admission_id' => $admission->id,
                            'student_id' => $admission->student_id,
                            'installment_number' => $index + 1,
                            'title' => $inst['title'] ?? ('Installment ' . ($index + 1)),
                            'due_date' => $inst['due_date'] ?? now()->addDays(30 * ($index + 1))->toDateString(),
                            'amount' => $instAmount,
                            'paid_amount' => 0,
                            'balance' => $instAmount,
                            'status' => 'Pending',
                            'notes' => $inst['notes'] ?? null,
                        ]);
                    }
                }
            }

            // Record initial payment if provided
            if ($initialPayment > 0) {
                $this->recordPayment([
                    'admission_id' => $admission->id,
                    'student_id' => $admission->student_id,
                    'amount' => $initialPayment,
                    'payment_date' => $data['admission_date'] ?? now()->toDateString(),
                    'payment_method' => $data['payment_method'] ?? 'Cash',
                    'transaction_number' => $data['transaction_number'] ?? null,
                    'notes' => 'Admission initial fee payment',
                    'collected_by' => auth()->id(),
                ]);
            }

            ActivityLog::log('created', 'Admission', $admission->id, "Admission #{$admission->admission_number} created for student ID {$admission->student_id}");

            return $admission->fresh(['student', 'course', 'batch', 'payments', 'installments']);
        });
    }

    /**
     * Record a fee payment and update admission balance & payment status
     */
    public function recordPayment(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $admission = Admission::findOrFail($data['admission_id']);
            $amount = (float) $data['amount'];

            if ($amount <= 0) {
                throw new Exception("Payment amount must be greater than zero.");
            }

            // Overpayment check
            if ($amount > $admission->balance && !($data['allow_overpayment'] ?? false)) {
                throw new Exception("Payment amount ({$amount}) exceeds the remaining balance ({$admission->balance}).");
            }

            $prefix = Setting::get('receipt_prefix', 'RCP-');
            $year = date('Y');
            $count = Payment::whereYear('created_at', $year)->count() + 1;
            $receiptNumber = sprintf('%s%s-%05d', $prefix, $year, $count);
            $paymentCode = 'PAY-' . strtoupper(Str::random(8));

            $payment = Payment::create([
                'payment_code' => $paymentCode,
                'receipt_number' => $receiptNumber,
                'admission_id' => $admission->id,
                'student_id' => $admission->student_id,
                'fee_installment_id' => $data['fee_installment_id'] ?? null,
                'amount' => $amount,
                'payment_date' => $data['payment_date'] ?? now()->toDateString(),
                'payment_method' => $data['payment_method'] ?? 'Cash',
                'transaction_number' => $data['transaction_number'] ?? null,
                'collected_by' => $data['collected_by'] ?? auth()->id(),
                'status' => 'completed',
                'notes' => $data['notes'] ?? null,
            ]);

            // Sync installment if tied
            if (!empty($data['fee_installment_id'])) {
                $installment = FeeInstallment::find($data['fee_installment_id']);
                if ($installment) {
                    $installment->recalculate();
                }
            } else {
                // Auto distribute to pending installments
                $remainingToDistribute = $amount;
                $installments = $admission->installments()->where('status', '!=', 'Paid')->get();
                foreach ($installments as $inst) {
                    if ($remainingToDistribute <= 0) break;
                    $instNeeded = $inst->balance;
                    $allocated = min($remainingToDistribute, $instNeeded);
                    $inst->paid_amount += $allocated;
                    $inst->balance = max(0, $inst->amount - $inst->paid_amount);
                    $inst->status = ($inst->balance <= 0) ? 'Paid' : 'Partially Paid';
                    $inst->save();
                    $remainingToDistribute -= $allocated;
                }
            }

            // Sync Admission totals
            $admission->recalculateTotals();

            ActivityLog::log('created', 'Payment', $payment->id, "Payment receipt #{$payment->receipt_number} of amount {$payment->amount} recorded");

            return $payment;
        });
    }
}
