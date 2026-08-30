<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Batch;
use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Enquiry;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\LeadSource;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Testimonial;
use App\Models\Trainer;
use App\Services\AdmissionFeeService;
use App\Services\CertificateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function home()
    {
        $featuredCourses = Course::with('category')
            ->where('status', 'active')
            ->where('featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        if ($featuredCourses->isEmpty()) {
            $featuredCourses = Course::with('category')->where('status', 'active')->take(6)->get();
        }

        $categories = CourseCategory::where('status', true)->withCount(['courses' => function ($q) {
            $q->where('status', 'active');
        }])->orderBy('sort_order')->take(8)->get();

        $trainers = Trainer::where('status', 'active')->take(4)->get();
        $testimonials = Testimonial::where('status', true)->where('featured', true)->orderBy('sort_order')->take(6)->get();
        $galleryImages = GalleryImage::where('status', true)->orderBy('sort_order')->take(8)->get();
        $faqs = Faq::where('status', true)->orderBy('sort_order')->take(6)->get();
        $latestBlogs = Blog::with('category')->where('status', 'published')->orderByDesc('published_at')->take(3)->get();

        $stats = [
            'students_trained' => Setting::get('stat_students_trained', '5,000+'),
            'placement_rate' => Setting::get('stat_placement_rate', '98%'),
            'active_courses' => Course::where('status', 'active')->count(),
            'expert_trainers' => Trainer::where('status', 'active')->count(),
            'experience_years' => Setting::get('stat_experience_years', '12+'),
        ];

        return view('frontend.home', compact(
            'featuredCourses',
            'categories',
            'trainers',
            'testimonials',
            'galleryImages',
            'faqs',
            'latestBlogs',
            'stats'
        ));
    }

    public function about()
    {
        $trainers = Trainer::where('status', 'active')->get();
        $testimonials = Testimonial::where('status', true)->take(6)->get();
        return view('frontend.about', compact('trainers', 'testimonials'));
    }

    public function courses(Request $request)
    {
        $query = Course::with('category')->where('status', 'active');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('course_name', 'like', "%{$searchTerm}%")
                  ->orWhere('short_description', 'like', "%{$searchTerm}%")
                  ->orWhere('course_code', 'like', "%{$searchTerm}%");
            });
        }

        $courses = $query->orderBy('sort_order')->paginate(9)->withQueryString();
        $categories = CourseCategory::where('status', true)->withCount('courses')->get();

        if ($request->ajax()) {
            return view('frontend.courses._course_grid', compact('courses'))->render();
        }

        return view('frontend.courses.index', compact('courses', 'categories'));
    }

    public function courseDetails(string $slug)
    {
        $course = Course::with(['category', 'syllabi', 'batches' => function ($q) {
            $q->whereIn('status', ['Upcoming', 'Active'])->orderBy('start_date');
        }])->where('slug', $slug)->firstOrFail();

        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'active')
            ->take(3)
            ->get();

        return view('frontend.courses.show', compact('course', 'relatedCourses'));
    }

    public function trainers()
    {
        $trainers = Trainer::where('status', 'active')->paginate(12);
        return view('frontend.trainers.index', compact('trainers'));
    }

    public function trainerDetails(int $id)
    {
        $trainer = Trainer::with(['batches.course'])->findOrFail($id);
        return view('frontend.trainers.show', compact('trainer'));
    }

    public function gallery(Request $request)
    {
        $categories = GalleryCategory::where('status', true)->orderBy('sort_order')->get();
        $query = GalleryImage::with('category')->where('status', true);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $images = $query->orderBy('sort_order')->paginate(12)->withQueryString();
        return view('frontend.gallery', compact('categories', 'images'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('status', true)->orderBy('sort_order')->paginate(12);
        return view('frontend.testimonials', compact('testimonials'));
    }

    public function faqs()
    {
        $faqs = Faq::where('status', true)->orderBy('sort_order')->get()->groupBy('category');
        return view('frontend.faq', compact('faqs'));
    }

    public function blogs(Request $request)
    {
        $query = Blog::with(['category', 'author'])->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $blogs = $query->orderByDesc('published_at')->paginate(6)->withQueryString();
        $categories = BlogCategory::where('status', true)->withCount('blogs')->get();
        $recentBlogs = Blog::where('status', 'published')->orderByDesc('published_at')->take(5)->get();

        return view('frontend.blog.index', compact('blogs', 'categories', 'recentBlogs'));
    }

    public function blogDetails(string $slug)
    {
        $blog = Blog::with(['category', 'author'])->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $blog->increment('views_count');

        $categories = BlogCategory::where('status', true)->withCount('blogs')->get();
        $recentBlogs = Blog::where('status', 'published')->where('id', '!=', $blog->id)->orderByDesc('published_at')->take(5)->get();

        return view('frontend.blog.show', compact('blog', 'categories', 'recentBlogs'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'mobile' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        $validated['ip_address'] = $request->ip();
        ContactMessage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been sent successfully. Our team will contact you shortly.',
        ]);
    }

    public function admission()
    {
        $courses = Course::where('status', 'active')->orderBy('course_name')->get();
        $batches = Batch::whereIn('status', ['Upcoming', 'Active'])->orderBy('start_date')->get();
        return view('frontend.admission', compact('courses', 'batches'));
    }

    public function submitEnquiry(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'message' => 'nullable|string|max:1000',
        ]);

        $webSource = LeadSource::firstOrCreate(
            ['name' => 'Website Enquiry'],
            ['slug' => 'website-enquiry', 'description' => 'Online web enquiry form', 'status' => true]
        );

        $enquiryCode = 'ENQ-' . date('Y') . '-' . strtoupper(Str::random(6));

        $enquiry = Enquiry::create([
            'enquiry_code' => $enquiryCode,
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['email'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'batch_id' => $validated['batch_id'] ?? null,
            'lead_source_id' => $webSource->id,
            'message' => $validated['message'] ?? 'Online enquiry submitted from website.',
            'status' => 'New',
            'follow_up_date' => now()->addDay()->toDateString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your enquiry! Our admissions counselor will call you within 24 hours.',
            'data' => [
                'enquiry_code' => $enquiry->enquiry_code,
            ],
        ]);
    }

    public function certificateVerify(Request $request, ?string $code = null)
    {
        $searchCode = $code ?? $request->query('code');
        $certificate = null;
        $searched = false;

        if ($searchCode) {
            $searched = true;
            $certificateService = app(CertificateService::class);
            $certificate = $certificateService->verify($searchCode);
        }

        if ($request->ajax()) {
            if ($certificate) {
                return response()->json([
                    'success' => true,
                    'html' => view('frontend.certificates._verification_card', compact('certificate'))->render(),
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'No valid certificate found for the provided Certificate Number / Verification Code.',
            ], 404);
        }

        return view('frontend.certificate-verify', compact('certificate', 'searched', 'searchCode'));
    }

    public function compliancePage(string $page)
    {
        $validPages = [
            'accessibility' => 'Accessibility Statement',
            'citizen-charter' => 'Citizen / Institute Charter',
            'privacy' => 'Privacy Policy',
            'terms' => 'Terms & Conditions',
            'disclaimer' => 'Disclaimer',
            'hyperlinking-policy' => 'Hyperlinking Policy',
            'copyright' => 'Copyright Policy',
            'sitemap' => 'Website Sitemap',
        ];

        if (!array_key_exists($page, $validPages)) {
            abort(404);
        }

        $title = $validPages[$page];
        $customPage = Page::where('slug', $page)->where('status', true)->first();

        return view("frontend.pages.{$page}", compact('title', 'customPage'));
    }
}
