<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;

class FrontendNavigationTest extends TestCase
{
    public function test_public_pages_load_successfully(): void
    {
        $this->get('/')->assertStatus(200)->assertSee('TechMaster');
        $this->get('/about')->assertStatus(200);
        $this->get('/courses')->assertStatus(200);

        $course = Course::first();
        if ($course) {
            $this->get("/courses/{$course->slug}")->assertStatus(200)->assertSee($course->course_name);
        }

        $this->get('/trainers')->assertStatus(200);
        $this->get('/gallery')->assertStatus(200);
        $this->get('/testimonials')->assertStatus(200);
        $this->get('/faq')->assertStatus(200);
        $this->get('/blog')->assertStatus(200);
        $this->get('/contact')->assertStatus(200);
        $this->get('/admission')->assertStatus(200);
        $this->get('/page/accessibility')->assertStatus(200)->assertSee('GIGW 3.0');
    }

    public function test_quick_enquiry_form_submission(): void
    {
        $course = Course::first();
        $response = $this->postJson(route('enquiry.submit'), [
            'name' => 'Test Lead Student',
            'mobile' => '9876598765',
            'email' => 'testlead@example.com',
            'course_id' => $course?->id,
            'message' => 'Automated test enquiry request for chip level course.',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('enquiries', [
            'mobile' => '9876598765',
            'name' => 'Test Lead Student',
        ]);
    }
}
