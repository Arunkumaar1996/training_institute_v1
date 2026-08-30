<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Admission;
use App\Services\AdmissionFeeService;

class AdmissionFeeTest extends TestCase
{
    public function test_admission_calculates_final_fee_and_balance_correctly(): void
    {
        $admin = User::first();
        $student = Student::first();
        $course = Course::first();

        $service = app(AdmissionFeeService::class);
        $admission = $service->createAdmission([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'admission_date' => now()->toDateString(),
            'course_fee' => 20000,
            'discount' => 2000,
            'initial_payment' => 8000,
            'payment_method' => 'UPI',
            'collected_by' => $admin->id,
        ]);

        $this->assertEquals(18000, $admission->final_fee);
        $this->assertEquals(8000, $admission->total_paid);
        $this->assertEquals(10000, $admission->balance);
        $this->assertEquals('Partially Paid', $admission->payment_status);
        $this->assertDatabaseHas('payments', [
            'admission_id' => $admission->id,
            'amount' => 8000,
            'payment_method' => 'UPI',
        ]);
    }
}
