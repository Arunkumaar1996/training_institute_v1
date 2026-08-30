<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Certificate;

class CertificateVerificationTest extends TestCase
{
    public function test_certificate_public_verification_portal(): void
    {
        $cert = Certificate::first();

        // 1. Web Page Route
        $response = $this->get(route('certificate.verify', ['code' => $cert->verification_code]));
        $response->assertStatus(200);
        $response->assertSee($cert->certificate_number);
        $response->assertSee($cert->student->full_name);

        // 2. Public API verification endpoint
        $apiResponse = $this->getJson("/api/v1/certificates/verify/{$cert->verification_code}");
        $apiResponse->assertStatus(200);
        $apiResponse->assertJsonPath('data.is_valid', true);
        $apiResponse->assertJsonPath('data.certificate_number', $cert->certificate_number);
    }
}
