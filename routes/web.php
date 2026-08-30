<?php

use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website & GIGW 3.0 Accessible Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses');
Route::get('/courses/{slug}', [FrontendController::class, 'courseDetails'])->name('course.details');
Route::get('/trainers', [FrontendController::class, 'trainers'])->name('trainers');
Route::get('/trainers/{id}', [FrontendController::class, 'trainerDetails'])->name('trainer.details');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/testimonials', [FrontendController::class, 'testimonials'])->name('testimonials');
Route::get('/faq', [FrontendController::class, 'faqs'])->name('faq');
Route::get('/blog', [FrontendController::class, 'blogs'])->name('blog');
Route::get('/blog/{slug}', [FrontendController::class, 'blogDetails'])->name('blog.details');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:10,1');
Route::get('/admission', [FrontendController::class, 'admission'])->name('admission');
Route::post('/enquiry', [FrontendController::class, 'submitEnquiry'])->name('enquiry.submit')->middleware('throttle:10,1');
Route::get('/certificate/verify/{code?}', [FrontendController::class, 'certificateVerify'])->name('certificate.verify');
Route::get('/pages/{page}', [FrontendController::class, 'compliancePage'])->name('page.show');
Route::get('/page/{page}', [FrontendController::class, 'compliancePage'])->name('page.show.alias');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

/*
|--------------------------------------------------------------------------
| Admin & Institute Management System Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Students Module
    Route::resource('students', StudentController::class);
    Route::post('students/{id}/documents', [StudentController::class, 'uploadDocument'])->name('students.documents.upload');
    Route::delete('students/{student}/documents/{document}', [StudentController::class, 'deleteDocument'])->name('students.documents.delete');
    Route::post('students/{id}/notes', [StudentController::class, 'addNote'])->name('students.notes.store');

    // Course Categories
    Route::resource('categories', CourseCategoryController::class);
    Route::post('categories/{id}/toggle-status', [CourseCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Courses & Syllabus
    Route::resource('courses', CourseController::class);
    Route::post('courses/{id}/toggle-featured', [CourseController::class, 'toggleFeatured'])->name('courses.toggle-featured');
    Route::post('courses/{id}/toggle-status', [CourseController::class, 'toggleStatus'])->name('courses.toggle-status');
    Route::post('courses/{id}/syllabus', [CourseController::class, 'storeSyllabus'])->name('courses.syllabus.store');
    Route::delete('courses/{course}/syllabus/{syllabus}', [CourseController::class, 'deleteSyllabus'])->name('courses.syllabus.delete');

    // Batches
    Route::resource('batches', BatchController::class);
    Route::post('batches/{id}/assign-students', [BatchController::class, 'assignStudents'])->name('batches.assign-students');
    Route::delete('batches/{batch}/students/{student}', [BatchController::class, 'removeStudent'])->name('batches.remove-student');

    // Admissions
    Route::resource('admissions', AdmissionController::class);

    // Fees & Installments
    Route::get('fees', [FeeController::class, 'index'])->name('fees.index');
    Route::get('fees/installments', [FeeController::class, 'installments'])->name('fees.installments');
    Route::get('fees/overdue', [FeeController::class, 'overdueFees'])->name('fees.overdue');

    // Payments & Receipts
    Route::resource('payments', PaymentController::class);
    Route::get('payments/{id}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

    // Attendance
    Route::get('attendance/students', [AttendanceController::class, 'studentAttendance'])->name('attendance.students');
    Route::post('attendance/students', [AttendanceController::class, 'saveStudentAttendance'])->name('attendance.students.save');
    Route::get('attendance/employees', [AttendanceController::class, 'employeeAttendance'])->name('attendance.employees');
    Route::post('attendance/employees', [AttendanceController::class, 'saveEmployeeAttendance'])->name('attendance.employees.save');
    Route::get('attendance/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');

    // Certificates
    Route::resource('certificates', CertificateController::class);
    Route::get('certificates/{id}/print', [CertificateController::class, 'print'])->name('certificates.print');

    // Enquiries / Leads CRM
    Route::resource('enquiries', EnquiryController::class);
    Route::post('enquiries/{id}/follow-ups', [EnquiryController::class, 'addFollowUp'])->name('enquiries.follow-ups.store');
    Route::post('enquiries/{id}/status', [EnquiryController::class, 'updateStatus'])->name('enquiries.status.update');

    // Trainers
    Route::resource('trainers', TrainerController::class);

    // Employees & Departments
    Route::resource('employees', EmployeeController::class);
    Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('departments', [DepartmentController::class, 'storeDepartment'])->name('departments.store');
    Route::post('designations', [DepartmentController::class, 'storeDesignation'])->name('designations.store');

    // Reports
    Route::get('reports/fees', [ReportController::class, 'feesReport'])->name('reports.fees');
    Route::get('reports/admissions', [ReportController::class, 'admissionsReport'])->name('reports.admissions');
    Route::get('reports/leads', [ReportController::class, 'leadsReport'])->name('reports.leads');

    // CMS & Website Management
    Route::get('cms/testimonials', [CmsController::class, 'testimonials'])->name('cms.testimonials');
    Route::post('cms/testimonials', [CmsController::class, 'storeTestimonial'])->name('cms.testimonials.store');
    Route::delete('cms/testimonials/{id}', [CmsController::class, 'deleteTestimonial'])->name('cms.testimonials.delete');

    Route::get('cms/gallery', [CmsController::class, 'gallery'])->name('cms.gallery');
    Route::post('cms/gallery', [CmsController::class, 'storeGalleryImage'])->name('cms.gallery.store');
    Route::delete('cms/gallery/{id}', [CmsController::class, 'deleteGalleryImage'])->name('cms.gallery.delete');

    Route::get('cms/faqs', [CmsController::class, 'faqs'])->name('cms.faqs');
    Route::post('cms/faqs', [CmsController::class, 'storeFaq'])->name('cms.faqs.store');
    Route::delete('cms/faqs/{id}', [CmsController::class, 'deleteFaq'])->name('cms.faqs.delete');

    Route::get('cms/blogs', [CmsController::class, 'blogs'])->name('cms.blogs');
    Route::get('cms/blogs/create', [CmsController::class, 'createBlog'])->name('cms.blogs.create');
    Route::post('cms/blogs', [CmsController::class, 'storeBlog'])->name('cms.blogs.store');
    Route::delete('cms/blogs/{id}', [CmsController::class, 'deleteBlog'])->name('cms.blogs.delete');

    Route::get('cms/contact-messages', [CmsController::class, 'contactMessages'])->name('cms.contact-messages');
    Route::post('cms/contact-messages/{id}/read', [CmsController::class, 'markMessageRead'])->name('cms.contact-messages.read');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Users & Roles (Super Admin / Admin only)
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // Audit Logs
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
});
