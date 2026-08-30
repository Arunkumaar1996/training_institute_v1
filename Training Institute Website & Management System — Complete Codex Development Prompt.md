# Training Institute Website & Management System — Complete gravity Development Prompt

## 1. Project Overview

Build a **fully dynamic, production-ready Training Institute Website and Institute Management System** using:

- **Laravel 12**
- **PHP 8.2**
- **MySQL**
- **Bootstrap 5**
- **HTML5**
- **CSS3**
- **JavaScript**
- **jQuery**
- **AJAX**
- **Blade Templates**
- **Laravel Authentication & Authorization**
- **REST API architecture where required**

The application is for a training institute that provides **Mobile and Laptop training courses from Basic to Advanced levels**.

The system must have two major parts:

1. **Public Business Website**
2. **Admin/Institute Management System**

The application must be **fully responsive, mobile-first, modern, fast, secure, dynamic, scalable, and production-ready**.

---

# 2. UI/UX Requirements

Create a modern **mobile-first Bootstrap 5 UI**.

The design must work perfectly on:

- Mobile phones
- Tablets
- Laptops
- Desktop computers
- Large screens

Use a modern professional training-institute design.

### Frontend Requirements

Use:

- Bootstrap 5
- Bootstrap Icons
- Font Awesome where required
- Modern cards
- Responsive tables
- Responsive forms
- Modal dialogs
- Offcanvas mobile menu
- Dropdown menus
- Tabs
- Accordion
- Breadcrumbs
- Alerts
- Toast notifications
- Badges
- Progress bars
- Dashboard statistics cards

Use AJAX wherever possible to avoid unnecessary page reloads.

Avoid outdated UI designs.

Use:

- Clean spacing
- Professional typography
- Consistent buttons
- Proper form validation
- Hover effects
- Loading indicators
- Empty states
- Confirmation dialogs

Use reusable Blade layouts/components.

Create:

```text
resources/views/
    layouts/
    components/
    admin/
    employee/
    student/
    trainer/
    frontend/
```

---

# 3. Public Website

Create a complete business website for the training institute.

## Homepage

Include:

- Hero section
- Institute introduction
- Courses
- Basic to Advanced training
- Why Choose Us
- Training methodology
- Featured courses
- Student success statistics
- Trainers
- Testimonials
- Gallery
- FAQ
- Contact section
- Google Map
- Call Now button
- WhatsApp button
- Enquiry form
- Admission CTA
- Footer

Example statistics:

- Students Trained
- Courses
- Trainers
- Years of Experience
- Placement/Success Statistics

All homepage content must be dynamically manageable from Admin.

---

# 4. Public Pages

Create:

```text
Home
About Us
Courses
Course Details
Trainers
Trainer Details
Gallery
Testimonials
FAQ
Blog
Blog Details
Student Reviews
Contact Us
Enquiry
Admission
Privacy Policy
Terms & Conditions
```

---

# 5. Course Management

Create a complete Course Management module.

Courses should support:

- Course name
- Course code
- Category
- Sub-category
- Short description
- Full description
- Course image
- Duration
- Duration type
- Level
- Basic
- Intermediate
- Advanced
- Course fee
- Discount fee
- Final fee
- Course syllabus
- Learning outcomes
- Requirements
- Certification available
- Status
- Featured
- Sort order
- SEO title
- SEO description
- SEO keywords

Admin should be able to:

- Create course
- Edit course
- View course
- Delete course
- Activate/deactivate
- Feature/unfeature
- Search
- Filter
- Sort
- Pagination

Use AJAX for status updates.

---

# 6. Course Categories

Create category management.

Fields:

- Category name
- Slug
- Description
- Image
- Status
- Sort order

Example categories:

```text
Mobile Basic
Mobile Hardware
Mobile Software
Mobile Repairing
Advanced Mobile Repairing
Laptop Basic
Laptop Hardware
Laptop Software
Laptop Repairing
Advanced Laptop Repairing
Chip Level Training
IC/Component Training
Advanced Technical Training
```

Do not hardcode these values. Admin must manage them dynamically.

---

# 7. Batch Management

Create Batch Management.

Each batch should contain:

- Batch number/code
- Course
- Trainer
- Start date
- End date
- Start time
- End time
- Days
- Maximum students
- Room
- Mode
  - Offline
  - Online
  - Hybrid
- Status

Statuses:

```text
Upcoming
Active
Completed
Cancelled
```

Provide:

- Batch listing
- Batch details
- Student assignment
- Trainer assignment
- Batch timetable
- Attendance integration

---

# 8. Student Management

Create a complete Student Management System.

Student fields:

### Personal Information

- Student ID
- First name
- Last name
- Date of birth
- Gender
- Profile photo
- Mobile
- Alternate mobile
- Email
- Blood group
- Aadhaar/ID number if required
- Address
- City
- State
- Country
- Pincode

### Parent/Guardian Information

- Parent name
- Guardian name
- Parent mobile
- Alternate mobile
- Parent occupation
- Emergency contact

### Education Information

- Qualification
- Institution
- Passing year
- Skills
- Previous experience

### Admission Information

- Admission number
- Admission date
- Course
- Batch
- Trainer
- Source
- Referral
- Admission status

### Documents

Support upload:

- ID proof
- Photo
- Certificates
- Other documents

Use secure file upload validation.

---

# 9. Student Profile

Create a complete student profile page.

Display:

```text
Student Information
Course Information
Batch Information
Trainer
Attendance
Fees
Payment History
Pending Balance
Documents
Certificates
Notes
Activity History
```

Use tabs.

Example:

```text
Overview
Attendance
Fees
Payments
Documents
Certificates
Notes
Activity
```

---

# 10. Student Admission Module

Create admission workflow.

Admin/employee should be able to:

- Register student
- Select course
- Select batch
- Assign trainer
- Enter course fee
- Enter discount
- Enter paid amount
- Automatically calculate balance
- Generate admission number
- Generate student ID
- Generate receipt

Formula:

```text
Final Fee = Course Fee - Discount

Balance = Final Fee - Total Paid
```

Prevent overpayment unless explicitly allowed.

---

# 11. Fees Management

Create complete Fees Management.

Each student should have:

```text
Course Fee
Discount
Final Fee
Paid Amount
Balance
Due Date
Payment Status
```

Payment statuses:

```text
Pending
Partially Paid
Paid
Overdue
```

---

# 12. Payment Management

Create payment module.

Payment fields:

- Payment ID
- Receipt number
- Student
- Admission
- Amount
- Payment date
- Payment method
- Transaction/reference number
- Notes
- Collected by

Payment methods:

```text
Cash
UPI
Bank Transfer
Card
Cheque
Online
Other
```

Automatically update:

```text
Total Paid
Remaining Balance
Payment Status
```

Create printable payment receipt.

---

# 13. Installment Management

Allow students to pay fees in installments.

Support:

- Installment schedule
- Due date
- Amount
- Paid amount
- Balance
- Status
- Reminder

Show overdue installments.

---

# 14. Fee Reports

Create reports:

- Daily collection
- Monthly collection
- Date-wise collection
- Course-wise collection
- Trainer-wise collection
- Student-wise fees
- Pending fees
- Overdue fees
- Paid fees
- Partial payments
- Payment method report

Allow:

- Search
- Filter
- Export
- Print

---

# 15. Trainer Management

Create Trainer Management.

Trainer fields:

- Trainer ID
- Name
- Profile photo
- Mobile
- Email
- Address
- Qualification
- Specialization
- Experience
- Joining date
- Salary
- Skills
- Bio
- Status

Trainer profile should show:

```text
Personal Details
Experience
Skills
Courses
Batches
Students
Attendance
Performance
```

---

# 16. Employee Management

Create Employee Management.

Fields:

- Employee ID
- Name
- Profile photo
- Mobile
- Email
- Address
- Date of birth
- Gender
- Qualification
- Department
- Designation
- Joining date
- Salary
- Employment type
- Status
- Emergency contact
- Documents

Departments:

```text
Admin
Reception
Accounts
Trainer
Marketing
Management
Support
```

Do not hardcode departments; create master management.

---

# 17. Employee Attendance

Create employee attendance.

Features:

- Daily attendance
- Present
- Absent
- Half Day
- Leave
- Holiday
- Late
- Check-in
- Check-out
- Remarks

Provide:

- Daily attendance
- Monthly attendance
- Employee-wise report
- Department-wise report

---

# 18. Student Attendance

Create student attendance.

Features:

- Batch-wise attendance
- Course-wise attendance
- Trainer-wise attendance
- Date-wise attendance
- Present
- Absent
- Late
- Leave

Trainer should be able to mark attendance for assigned batches.

Use AJAX attendance marking.

Provide:

```text
Present All
Absent All
Individual Update
Save Attendance
```

Prevent duplicate attendance for the same student/batch/date.

---

# 19. Attendance Reports

Create:

- Daily attendance report
- Monthly attendance report
- Student attendance percentage
- Batch attendance
- Trainer attendance
- Absentees list
- Low-attendance students

Calculate:

```text
Attendance %
= Present Days / Total Working Days × 100
```

---

# 20. Certificate Management

Create certificate module.

Features:

- Certificate templates
- Certificate number
- Student
- Course
- Batch
- Issue date
- Completion date
- Trainer
- Grade/result
- Status

Generate printable certificate.

Provide certificate verification page:

```text
/certificate/verify/{certificate_number}
```

Anyone can verify a certificate using the certificate number.

---

# 21. Enquiry / Lead Management

Create enquiry management for business growth.

Fields:

- Enquiry ID
- Name
- Mobile
- Email
- Course interested
- Preferred batch
- Source
- Message
- Follow-up date
- Assigned employee
- Status

Statuses:

```text
New
Contacted
Interested
Follow-up
Converted
Not Interested
Closed
```

Create follow-up management.

---

# 22. Lead Source Management

Create dynamic lead sources:

```text
Google
Facebook
Instagram
WhatsApp
Website
Referral
Walk-in
Advertisement
Other
```

Admin can add/edit/delete sources.

---

# 23. Follow-up Management

Create follow-up system.

Fields:

- Lead
- Employee
- Follow-up date
- Follow-up time
- Notes
- Status
- Next follow-up

Dashboard should display:

```text
Today's Follow-ups
Upcoming Follow-ups
Overdue Follow-ups
```

---

# 24. Student Communication

Create communication features.

Allow sending:

- Email
- SMS integration-ready
- WhatsApp integration-ready

Notifications:

```text
Admission Confirmation
Payment Receipt
Fee Due Reminder
Attendance Alert
Course Completion
Certificate Ready
Follow-up Reminder
```

Build the architecture so external SMS/WhatsApp providers can be integrated later.

---

# 25. Website Enquiry Form

Frontend enquiry form should save directly into Lead/Enquiry Management.

Fields:

```text
Name
Mobile
Email
Course
Preferred Batch
Message
```

Use AJAX.

Implement:

- Server-side validation
- CSRF
- Rate limiting
- Duplicate enquiry protection where appropriate
- Success/error response

---

# 26. Testimonials

Create testimonial CRUD.

Fields:

- Student
- Name
- Photo
- Course
- Rating
- Review
- Status
- Featured
- Sort order

Display dynamically on website.

---

# 27. Gallery

Create gallery management.

Support:

- Gallery categories
- Multiple images
- Image title
- Description
- Status
- Sort order

Frontend gallery should be responsive.

---

# 28. Blog / News Management

Create blog module.

Fields:

- Title
- Slug
- Featured image
- Category
- Content
- Author
- Tags
- SEO title
- SEO description
- SEO keywords
- Status
- Published date

Provide:

- Draft
- Published
- Scheduled

Frontend blog listing and details page.

---

# 29. FAQ Management

Create FAQ CRUD.

Fields:

- Question
- Answer
- Category
- Sort order
- Status

Display using Bootstrap accordion.

---

# 30. Contact Management

Create:

- Contact information
- Phone
- Email
- Address
- Google Map URL
- Working hours
- Social media links

All must be manageable from admin.

---

# 31. Business Growth Dashboard

Create an advanced dashboard.

Show:

### Student Statistics

```text
Total Students
Active Students
Completed Students
New Students
```

### Course Statistics

```text
Total Courses
Active Courses
Popular Courses
```

### Financial Statistics

```text
Today's Collection
This Month Collection
Total Collection
Pending Fees
Overdue Fees
```

### Lead Statistics

```text
Total Enquiries
New Leads
Follow-ups
Converted Leads
Conversion Rate
```

### Attendance

```text
Today's Student Attendance
Employee Attendance
Absent Students
```

### Charts

Use Chart.js.

Charts:

- Monthly admissions
- Monthly revenue
- Course popularity
- Lead conversion
- Attendance statistics
- Payment methods

---

# 32. Dashboard Quick Actions

Create buttons:

```text
Add Student
New Admission
Add Payment
Add Enquiry
Mark Attendance
Add Course
Add Batch
Add Employee
Add Trainer
```

---

# 33. Authentication

Implement secure authentication.

Roles:

```text
Super Admin
Admin
Manager
Accountant
Receptionist
Trainer
Employee
```

Use role-based authorization.

Permissions should control:

```text
Dashboard
Students
Admissions
Courses
Batches
Trainers
Employees
Attendance
Fees
Payments
Certificates
Enquiries
Follow-ups
Reports
Website Content
Settings
Users
Roles
Permissions
```

Users should only access authorized modules.

---

# 34. User Management

Create User Management.

Fields:

- Name
- Email
- Mobile
- Password
- Role
- Employee/Trainer relation
- Profile photo
- Status
- Last login

Implement:

- Create
- Edit
- View
- Delete
- Activate/deactivate
- Reset password

Never store plain-text passwords.

Use Laravel hashing.

---

# 35. Role & Permission Management

Implement proper RBAC.

Admin can:

- Create role
- Edit role
- Delete role
- Assign permissions

Permission examples:

```text
student.view
student.create
student.edit
student.delete

course.view
course.create
course.edit
course.delete

payment.view
payment.create
payment.edit
payment.delete

attendance.view
attendance.create
attendance.edit
```

Use middleware/policies/gates correctly.

---

# 36. Master Settings

Create settings module.

Manage:

```text
Institute Name
Logo
Favicon
Phone
Email
Address
Website
Working Hours
Tax/GST Information
Receipt Prefix
Admission Prefix
Student ID Prefix
Certificate Prefix
Currency
Date Format
Timezone
Social Media
```

---

# 37. Document Management

Provide secure document uploads.

Requirements:

- File type validation
- File size validation
- Secure filenames
- Private storage where required
- Authorization checks
- Download permission checks

Never allow arbitrary executable file uploads.

---

# 38. Search

Global search should support:

```text
Student
Employee
Trainer
Course
Batch
Payment
Admission
Enquiry
Certificate
```

Use AJAX search where useful.

---

# 39. DataTables

For large datasets, use server-side pagination/search/filtering.

Tables should include:

- Search
- Pagination
- Sorting
- Filters
- Export where appropriate
- Responsive design

Use Yajra DataTables only if needed and compatible with Laravel 12.

---

# 40. AJAX Requirements

Use jQuery AJAX for:

- Status updates
- Search
- Filters
- Attendance
- Payment updates
- Enquiry updates
- Dependent dropdowns
- Modal CRUD
- Quick actions

Return consistent JSON:

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {}
}
```

For validation:

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {}
}
```

---

# 41. Validation

Use Laravel Form Requests.

Every module must have proper validation.

Examples:

- Required fields
- Email validation
- Mobile validation
- Numeric validation
- Date validation
- Unique fields
- File validation
- Foreign key validation

Never rely only on JavaScript validation.

---

# 42. Security Requirements

Security is extremely important.

Implement:

- CSRF protection
- XSS protection
- SQL injection protection
- Laravel validation
- Authorization
- Policies
- Gates
- Middleware
- Rate limiting
- Secure file uploads
- Password hashing
- Session security
- Authentication throttling
- Mass assignment protection
- Secure API authentication
- Audit logs

Do not use raw SQL unless absolutely necessary.

Use:

```text
Eloquent ORM
Query Builder
Form Requests
Policies
Services
Repositories where useful
```

---

# 43. Audit Log

Create activity/audit log.

Track:

```text
Login
Logout
Student Created
Student Updated
Student Deleted
Payment Created
Payment Updated
Attendance Updated
Course Created
User Changes
Settings Changes
```

Store:

- User
- Action
- Module
- Record ID
- IP address
- User agent
- Timestamp
- Old values
- New values

---

# 44. Reports

Create comprehensive reporting system.

Reports:

```text
Student Report
Admission Report
Course Report
Batch Report
Trainer Report
Employee Report
Attendance Report
Fee Report
Payment Report
Pending Fee Report
Lead Report
Follow-up Report
Certificate Report
```

Each report should support:

- Date filters
- Course filter
- Batch filter
- Trainer filter
- Status filter
- Search
- Print
- Export

---

# 45. Invoice / Receipt

Create professional printable receipt.

Include:

```text
Institute Logo
Institute Name
Address
Phone
Receipt Number
Date

Student Name
Student ID
Course
Batch

Course Fee
Discount
Final Fee
Previous Paid
Current Payment
Total Paid
Balance

Payment Method
Transaction Number

Collected By

Terms & Conditions
Authorized Signature
```

---

# 46. API

Create secure REST APIs for future mobile application integration.

Use Laravel API authentication such as Sanctum where appropriate.

API modules:

```text
/auth/login
/auth/logout
/auth/profile

/students
/courses
/batches
/trainers
/attendance
/payments
/fees
/enquiries
/certificates
/dashboard
```

Implement:

- Authentication
- Authorization
- API validation
- Pagination
- Rate limiting
- Consistent responses
- API Resources
- Proper HTTP status codes

Never expose sensitive information through APIs.

---

# 47. Database Architecture

Create proper normalized MySQL database.

Suggested tables:

```text
users
roles
permissions
role_user
permission_role

students
student_documents
student_notes

courses
course_categories
course_syllabus

batches
batch_students
batch_trainers

trainers
employees
departments
designations

student_attendance
employee_attendance

admissions
admission_payments
payments
fee_installments

certificates
certificate_templates

enquiries
lead_sources
follow_ups

testimonials
gallery_categories
gallery_images

blogs
blog_categories
blog_tags

faqs

settings
pages
contact_messages

notifications
activity_logs
```

Use proper:

- Primary keys
- Foreign keys
- Indexes
- Unique constraints
- Nullable relationships
- Cascade/restrict behavior

Avoid unnecessary duplication.

---

# 48. Database Requirements

Every migration must be correct and executable.

Use:

```php
$table->foreignId(...)
$table->timestamps();
$table->softDeletes();
```

where appropriate.

Add indexes to frequently searched columns:

```text
student_id
mobile
email
course_id
batch_id
trainer_id
payment_date
attendance_date
status
```

Avoid N+1 queries using eager loading.

---

# 49. Soft Deletes

Use soft deletes for important business records such as:

```text
Students
Employees
Trainers
Courses
Batches
Payments where appropriate
Enquiries
```

Do not permanently delete important financial records unless explicitly required.

---

# 50. Notifications

Create Laravel notification architecture.

Notifications:

```text
Fee Due
Payment Received
Admission Created
Follow-up Due
Attendance Alert
Certificate Generated
```

Make notification channels configurable.

---

# 51. Responsive Admin Layout

Admin dashboard:

### Desktop

Left sidebar:

```text
Dashboard

Management
  Students
  Admissions
  Courses
  Categories
  Batches
  Trainers
  Employees

Finance
  Fees
  Payments
  Receipts
  Reports

Attendance
  Student Attendance
  Employee Attendance

Business
  Enquiries
  Follow-ups
  Testimonials

Website
  Pages
  Blog
  Gallery
  FAQ
  Contact

Certificates

Reports

Users & Roles

Settings
```

### Mobile

Use Bootstrap offcanvas sidebar.

Header should contain:

- Menu
- Logo
- Notifications
- Profile
- Logout

---

# 52. Frontend SEO

Implement SEO-friendly pages.

Include:

- Dynamic title
- Meta description
- Meta keywords where appropriate
- Open Graph tags
- Canonical URL
- SEO-friendly slugs
- Sitemap-ready architecture
- Robots.txt support
- Schema.org structured data where appropriate

Course pages should be SEO friendly.

---

# 53. Performance

Optimize application.

Use:

- Eager loading
- Pagination
- Database indexes
- Query optimization
- Cache configuration
- Asset optimization
- Lazy loading images
- AJAX where appropriate

Avoid loading unnecessary data.

---

# 54. Error Handling

Create proper error handling.

Pages:

```text
404
403
419
422
429
500
503
```

Show user-friendly messages.

Do not expose:

- SQL errors
- Stack traces
- Passwords
- API secrets
- Environment variables

in production.

---

# 55. Code Architecture

Follow Laravel best practices.

Use:

```text
Models
Controllers
Form Requests
Policies
Middleware
Services
Notifications
Events
Jobs
Resources
Scopes
Observers
```

Avoid putting all business logic directly inside controllers.

Controllers should remain clean.

Example:

```text
StudentController
StudentService
StudentStoreRequest
StudentUpdateRequest
StudentPolicy
```

---

# 56. Routes

Organize routes properly.

Example:

```text
routes/web.php
routes/api.php
```

Use route groups:

```php
Route::middleware(['auth'])->group(...)
```

Use named routes.

Use prefixes:

```text
/admin
/student
/trainer
/employee
```

Avoid duplicate routes.

---

# 57. Seeders

Create realistic seed data.

Create:

- Super Admin
- Admin
- Accountant
- Receptionist
- Trainer
- Sample courses
- Categories
- Departments
- Designations
- Sample batches
- Sample students
- Sample employees

Provide login credentials in README only for development/demo use.

---

# 58. Factories

Create factories for:

```text
Student
Employee
Trainer
Course
Batch
Payment
Enquiry
```

Use factories for testing.

---

# 59. Testing

Create Feature/Unit tests for critical functionality.

Test:

```text
Authentication
Authorization
Student CRUD
Admission
Fee calculation
Payment
Balance calculation
Attendance
Certificate verification
Enquiry
API authentication
```

Important fee calculation tests:

```text
Course Fee = 10000
Discount = 1000
Final Fee = 9000
Paid = 5000
Balance = 4000
```

Ensure calculations are correct.

---

# 60. Important Business Rules

Implement these rules:

### Fee

```text
Final Fee = Course Fee - Discount

Balance = Final Fee - Total Paid
```

### Payment

Payment cannot exceed remaining balance unless an admin explicitly enables overpayment.

### Attendance

A student cannot have duplicate attendance for:

```text
student + batch + date
```

### Batch

Do not allow a student to exceed batch capacity.

### Certificate

Certificate should only be generated for eligible/completed students according to institute rules.

### Authorization

Trainer can only access students/batches assigned to that trainer unless their role grants broader permission.

### Financial Records

Do not silently delete payment records.

---

# 61. Business Analytics

Create useful business metrics:

```text
Total Admissions
Monthly Admissions
Course-wise Admissions
Revenue Growth
Pending Fees
Lead Conversion Rate
Most Popular Course
Trainer Performance
Student Attendance
Course Completion
```

Show charts and KPI cards.

---

# 62. Mobile UX

Mobile experience is extremely important.

Make sure:

- No horizontal scrolling
- Tables become responsive cards or scroll containers
- Forms stack vertically
- Buttons are touch-friendly
- Sidebar becomes offcanvas
- Modals fit mobile screens
- Dashboard cards stack correctly
- Navigation works on small screens
- File upload works on mobile
- WhatsApp/call buttons work on mobile

Test at:

```text
320px
375px
390px
414px
768px
1024px
1366px
1920px
```

---

# 63. PWA-Ready Architecture

Structure the application so a Progressive Web App can be added later.

Keep:

- Mobile-first UI
- API architecture
- Responsive components
- Offline-ready considerations

---

# 64. Development Standards

Follow:

- PSR-12
- Laravel coding standards
- DRY principle
- SOLID principles
- Reusable components
- Meaningful variable names
- Proper comments only where needed

Do not create duplicated code.

---

# 65. Important Requirement: Dynamic System

Do NOT hardcode:

- Courses
- Trainers
- Students
- Employees
- Fees
- Batches
- Testimonials
- Gallery
- FAQs
- Website information
- Departments
- Designations
- Lead sources
- Payment methods

Everything should be database-driven and manageable from the admin panel.

---

# 66. Deliverables

Build the complete working Laravel application.

Deliver:

```text
Complete Laravel 12 project
Database migrations
Models
Relationships
Controllers
Form Requests
Services
Policies
Middleware
Routes
Blade templates
Bootstrap 5 UI
JavaScript
jQuery AJAX
Authentication
Authorization
RBAC
REST APIs
Seeders
Factories
Tests
Reports
Receipt generation
Certificate generation
Audit logs
Notifications
Settings
SEO
Responsive design
README
```

---

# 67. Development Process

Do NOT create only a mockup or static frontend.

Build actual functional modules connected to MySQL.

Before considering the project complete:

1. Configure database.
2. Create all migrations.
3. Run migrations successfully.
4. Create models and relationships.
5. Create seeders.
6. Implement authentication.
7. Implement roles and permissions.
8. Implement admin dashboard.
9. Implement Student Management.
10. Implement Course Management.
11. Implement Batch Management.
12. Implement Trainer Management.
13. Implement Employee Management.
14. Implement Admission.
15. Implement Fees.
16. Implement Payments.
17. Implement Attendance.
18. Implement Certificates.
19. Implement Enquiries.
20. Implement Follow-ups.
21. Implement Website CMS.
22. Implement Reports.
23. Implement APIs.
24. Implement validation.
25. Implement security.
26. Implement responsive UI.
27. Add tests.
28. Fix errors.
29. Optimize queries.
30. Verify all CRUD operations.

---

# 68. Critical gravity Instructions

When generating code:

- Do not overwrite existing working code unnecessarily.
- First inspect the existing project structure.
- Reuse existing components when possible.
- Before creating a new class/model/controller, check whether it already exists.
- Keep migrations consistent.
- Check foreign key dependencies before creating migrations.
- Do not duplicate migrations or routes.
- Do not create duplicate table names.
- Do not use deprecated Laravel APIs.
- Use Laravel 12 compatible syntax.
- Use PHP 8.2 compatible syntax.
- Do not use packages unless necessary.
- If a package is required, explain why and install a Laravel 12 compatible version.
- Do not use Bootstrap 4.
- Use Bootstrap 5.
- Use jQuery for AJAX interactions.
- Keep frontend mobile-first.
- Use secure coding practices.
- Never expose `.env` values.
- Never commit credentials/API keys.
- Use `.env.example`.

---

# 69. Final Verification Checklist

Before finishing, verify:

### Authentication

- Login works
- Logout works
- Password reset works
- Roles work
- Permissions work

### Students

- Create
- Edit
- View
- Delete/soft delete
- Documents
- Attendance
- Fees
- Payments

### Courses

- CRUD
- Categories
- Syllabus
- Frontend display

### Batches

- CRUD
- Trainer assignment
- Student assignment
- Capacity validation

### Finance

- Admission fees
- Discount
- Payment
- Installments
- Balance
- Receipts
- Reports

### Attendance

- Student attendance
- Employee attendance
- Reports
- Percentage calculation

### Business

- Enquiries
- Leads
- Follow-ups
- Conversion tracking

### Website

- Homepage
- Courses
- Trainers
- Testimonials
- Gallery
- Blog
- FAQ
- Contact

### Certificates

- Generate
- Print
- Verify

### API

- Login
- Authentication
- CRUD
- Pagination
- Validation
- Authorization

### Responsive

Verify mobile, tablet, laptop and desktop layouts.

---

# 70. Final Instruction to gravity

Build this as a **real-world production-ready Training Institute Management & Business Growth Platform**, not a demo application.

The system should be:

**Secure + Dynamic + Responsive + Mobile First + SEO Friendly + Scalable + Maintainable + API Ready + Business Oriented.**

Prioritize functionality, database integrity, security, usability, and clean Laravel architecture.

When implementing each module, provide complete working code rather than pseudo-code.

If an implementation decision is required, choose the solution that follows Laravel 12 and PHP 8.2 best practices and keeps the application maintainable and scalable.

After implementation, check for:

- PHP errors
- Laravel errors
- SQL errors
- Migration errors
- Foreign key errors
- JavaScript errors
- AJAX errors
- Responsive UI issues
- Authorization issues
- Validation issues
- N+1 queries
- Security issues

Fix all discovered issues before moving to the next module.