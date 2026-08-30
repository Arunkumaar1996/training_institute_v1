<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Admission;
use App\Models\Certificate;
use App\Models\Setting;
use App\Models\Student;
use Exception;
use Illuminate\Support\Str;

class CertificateService
{
    public function generateCertificate(array $data): Certificate
    {
        $student = Student::findOrFail($data['student_id']);

        // Check if certificate already exists for this course
        $existing = Certificate::where('student_id', $data['student_id'])
            ->where('course_id', $data['course_id'])
            ->first();

        if ($existing && !($data['force_regenerate'] ?? false)) {
            return $existing;
        }

        $prefix = Setting::get('certificate_prefix', 'CRT-');
        $year = date('Y');
        $count = Certificate::whereYear('created_at', $year)->count() + 1;
        $certificateNumber = sprintf('%s%s-%04d', $prefix, $year, $count);
        $verificationCode = strtoupper(Str::random(10));

        $certificate = Certificate::create([
            'certificate_number' => $certificateNumber,
            'verification_code' => $verificationCode,
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
            'batch_id' => $data['batch_id'] ?? null,
            'trainer_id' => $data['trainer_id'] ?? null,
            'template_id' => $data['template_id'] ?? null,
            'issue_date' => $data['issue_date'] ?? now()->toDateString(),
            'completion_date' => $data['completion_date'] ?? now()->toDateString(),
            'grade' => $data['grade'] ?? 'Grade A',
            'status' => 'Issued',
            'remarks' => $data['remarks'] ?? null,
        ]);

        ActivityLog::log('created', 'Certificate', $certificate->id, "Certificate #{$certificate->certificate_number} issued to {$student->full_name}");

        return $certificate->load(['student', 'course', 'batch', 'trainer']);
    }

    public function verify(string $code): ?Certificate
    {
        $code = trim(strtoupper($code));
        return Certificate::with(['student', 'course', 'batch', 'trainer'])
            ->where('verification_code', $code)
            ->orWhere('certificate_number', $code)
            ->first();
    }
}
