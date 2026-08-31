<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Page;
use App\Models\Student;
use App\Models\Testimonial;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CmsController extends Controller
{
    // Testimonials
    public function testimonials(): View
    {
        $testimonials = Testimonial::with('course')->orderBy('sort_order')->paginate(15);
        $courses = Course::where('status', 'active')->get();
        return view('admin.cms.testimonials', compact('testimonials', 'courses'));
    }

    public function storeTestimonial(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'course_id' => 'nullable|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'featured' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['featured'] = $request->boolean('featured', true);
        $validated['status'] = true;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/testimonials');
        }

        Testimonial::create($validated);
        return back()->with('success', 'Testimonial added successfully.');
    }

    public function deleteTestimonial(int $id): RedirectResponse
    {
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    // Gallery
    public function gallery(): View
    {
        $images = GalleryImage::with('category')->orderBy('sort_order')->paginate(15);
        $categories = GalleryCategory::where('status', true)->get();
        return view('admin.cms.gallery', compact('images', 'categories'));
    }

    public function storeGalleryImage(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        if ($request->has('category_id') && !$request->has('gallery_category_id')) {
            $request->merge(['gallery_category_id' => $request->category_id]);
        }

        $validated = $request->validate([
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:300',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validated['image_path'] = $fileStorage->uploadImage($request->file('image'), 'uploads/gallery');
        $validated['status'] = true;

        GalleryImage::create($validated);
        return back()->with('success', 'Gallery image uploaded.');
    }

    public function deleteGalleryImage(int $id): RedirectResponse
    {
        GalleryImage::findOrFail($id)->delete();
        return back()->with('success', 'Image removed.');
    }

    // FAQs
    public function faqs(): View
    {
        $faqs = Faq::orderBy('category')->orderBy('sort_order')->paginate(20);
        return view('admin.cms.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|max:50',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['status'] = true;
        Faq::create($validated);

        return back()->with('success', 'FAQ question created.');
    }

    public function deleteFaq(int $id): RedirectResponse
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ removed.');
    }

    // Blogs
    public function blogs(): View
    {
        $blogs = Blog::with(['category', 'author'])->orderByDesc('id')->paginate(15);
        return view('admin.cms.blogs.index', compact('blogs'));
    }

    public function createBlog(): View
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('admin.cms.blogs.create', compact('categories'));
    }

    public function storeBlog(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        if ($request->has('category_id') && !$request->has('blog_category_id')) {
            $request->merge(['blog_category_id' => $request->category_id]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'tags' => 'nullable|string|max:200',
            'status' => 'required|string|in:published,draft,scheduled',
            'seo_title' => 'nullable|string|max:150',
            'seo_description' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title'] . '-' . Str::random(4));
        $validated['author_id'] = auth()->id();
        $validated['published_at'] = ($validated['status'] === 'published') ? now() : null;

        if ($request->hasFile('image')) {
            $validated['featured_image'] = $fileStorage->uploadImage($request->file('image'), 'uploads/blogs');
        }

        Blog::create($validated);
        return redirect()->route('admin.cms.blogs')->with('success', 'Blog article published successfully.');
    }

    public function editBlog(int $id): View
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::where('status', true)->get();
        return view('admin.cms.blogs.edit', compact('blog', 'categories'));
    }

    public function updateBlog(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $blog = Blog::findOrFail($id);

        if ($request->has('category_id') && !$request->has('blog_category_id')) {
            $request->merge(['blog_category_id' => $request->category_id]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:300',
            'content' => 'required|string',
            'tags' => 'nullable|string|max:200',
            'status' => 'required|string|in:published,draft,scheduled',
            'seo_title' => 'nullable|string|max:150',
            'seo_description' => 'nullable|string|max:300',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $fileStorage->uploadImage($request->file('featured_image'), 'uploads/blogs');
        }

        $blog->update($validated);
        return redirect()->route('admin.cms.blogs')->with('success', 'Blog article updated successfully.');
    }

    public function deleteBlog(int $id): RedirectResponse
    {
        Blog::findOrFail($id)->delete();
        return back()->with('success', 'Blog deleted.');
    }

    // Contact Messages
    public function contactMessages(): View
    {
        $messages = ContactMessage::orderByDesc('id')->paginate(20);
        return view('admin.cms.contact-messages', compact('messages'));
    }

    public function markMessageRead(int $id): RedirectResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        return back()->with('success', 'Marked as read.');
    }
}
