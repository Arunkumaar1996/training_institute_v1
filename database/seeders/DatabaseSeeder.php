<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Trainer;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseSyllabus;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Admission;
use App\Models\Payment;
use App\Models\FeeInstallment;
use App\Models\StudentAttendance;
use App\Models\EmployeeAttendance;
use App\Models\Certificate;
use App\Models\LeadSource;
use App\Models\Enquiry;
use App\Models\FollowUp;
use App\Models\Testimonial;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Faq;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full administrative root access'],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Institute operational management'],
            ['name' => 'Counselor', 'slug' => 'counselor', 'description' => 'Lead management and student admissions'],
            ['name' => 'Accountant', 'slug' => 'accountant', 'description' => 'Fee collections, receipts and accounting'],
            ['name' => 'Trainer', 'slug' => 'trainer', 'description' => 'Faculty course delivery and attendance'],
            ['name' => 'Student', 'slug' => 'student', 'description' => 'Student self-service access'],
        ];

        $roleModels = [];
        foreach ($roles as $r) {
            $roleModels[$r['slug']] = Role::create($r);
        }

        $modules = ['students', 'admissions', 'courses', 'batches', 'fees', 'attendance', 'certificates', 'enquiries', 'trainers', 'employees', 'cms', 'settings'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $mod) {
            foreach ($actions as $act) {
                $perm = Permission::create([
                    'name' => ucfirst($act) . ' ' . ucfirst($mod),
                    'slug' => "{$mod}.{$act}",
                    'group' => $mod,
                ]);
                $roleModels['super-admin']->permissions()->attach($perm->id);
                $roleModels['admin']->permissions()->attach($perm->id);
            }
        }

        // 2. Users
        $adminUser = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@institute.com',
            'mobile' => '9876543210',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        $adminUser->roles()->attach($roleModels['super-admin']->id);

        $counselorUser = User::create([
            'name' => 'Pooja Sharma (Counselor)',
            'email' => 'counselor@institute.com',
            'mobile' => '9876543211',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        $counselorUser->roles()->attach($roleModels['counselor']->id);

        $accountantUser = User::create([
            'name' => 'Karthik Raja (Accountant)',
            'email' => 'accounts@institute.com',
            'mobile' => '9876543212',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        $accountantUser->roles()->attach($roleModels['accountant']->id);

        // 3. Settings
        $settings = [
            'institute_name' => 'TechMaster Training Institute',
            'institute_tagline' => 'Premier Mobile & Laptop Chip-Level Repair Academy',
            'contact_phone' => '+91 7418191487',
            'contact_phone_alt' => '+91 7418191487',
            'contact_email' => 'aruntech1996@gmail.com',
            'contact_address' => 'alwarthirunagar, valasaravakkam, chennai-600 087.',
            'working_hours' => 'Monday - Saturday: 9:00 AM to 7:00 PM',
            'whatsapp_number' => '+917418191487',
            'telegram_channel' => 'https://t.me/techmaster_circuits',
            'youtube_url' => 'https://youtube.com',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'meta_title_default' => 'TechMaster Training Institute | Mobile & Laptop Chip-Level Course',
            'meta_description_default' => 'India leading practical chip-level training institute for mobile smartphone hardware, BGA micro-soldering, and laptop logic board repairs.',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val, 'general');
        }

        // 4. Lead Sources
        $sources = ['Website Enquiry', 'Walk-in Visit', 'Student Referral', 'Instagram / Social Media', 'YouTube Video', 'Google Search'];
        $sourceModels = [];
        foreach ($sources as $s) {
            $sourceModels[] = LeadSource::create([
                'name' => $s,
                'slug' => Str::slug($s),
                'status' => true,
            ]);
        }

        // 5. Departments & Designations
        $deptLabs = Department::create(['name' => 'Technical & Laboratory Training', 'status' => true]);
        $deptAdmin = Department::create(['name' => 'Admissions & Student Relations', 'status' => true]);
        $deptAccounts = Department::create(['name' => 'Finance & Administration', 'status' => true]);

        $desigInstructor = Designation::create(['department_id' => $deptLabs->id, 'title' => 'Chief Hardware Instructor', 'status' => true]);
        $desigCounselor = Designation::create(['department_id' => $deptAdmin->id, 'title' => 'Senior Admissions Counselor', 'status' => true]);

        // 6. Employees & Trainers
        $emp1 = Employee::create([
            'employee_code' => 'EMP-2026-0001',
            'department_id' => $deptAdmin->id,
            'designation_id' => $desigCounselor->id,
            'first_name' => 'Pooja',
            'last_name' => 'Sharma',
            'gender' => 'Female',
            'mobile' => '9876543211',
            'email' => 'counselor@institute.com',
            'joining_date' => '2025-01-10',
            'salary' => 35000,
            'status' => 'active',
        ]);

        $trainer1 = Trainer::create([
            'trainer_code' => 'TRN-2026-0001',
            'name' => 'Er. Suresh Kumar',
            'mobile' => '9876543215',
            'email' => 'suresh.trainer@institute.com',
            'specialization' => 'iPhone & Android Chip-Level Diagnostics',
            'experience_years' => 12,
            'qualification' => 'B.E Electronics, Master SMD Technician',
            'skills' => 'Micro-soldering, Thermal Camera Tracing, Oscilloscope Diagnostics, BGA Reballing',
            'bio' => 'Over 12 years of hands-on expertise in motherboard micro-soldering, circuit schematics, and CPU/eMMC transplanting.',
            'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
            'status' => true,
        ]);

        $trainer2 = Trainer::create([
            'trainer_code' => 'TRN-2026-0002',
            'name' => 'K. Vignesh',
            'mobile' => '9876543216',
            'email' => 'vignesh.trainer@institute.com',
            'specialization' => 'Laptop Logic Board & Power Rail Troubleshooting',
            'experience_years' => 9,
            'qualification' => 'Diploma Hardware & Network Eng.',
            'skills' => '3V/5V Standby Rails, IO Controller Programming, BIOS Reprogramming, Mosfet Shorting Analysis',
            'bio' => 'Expert instructor in laptop schematic analysis, boardview diagnostics, and high-frequency power management circuits.',
            'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
            'status' => true,
        ]);

        $trainer3 = Trainer::create([
            'trainer_code' => 'TRN-2026-0003',
            'name' => 'Amitabh Sen',
            'mobile' => '9876543217',
            'email' => 'amitabh.trainer@institute.com',
            'specialization' => 'Smartphone Flashing, EMMC & UFS Programming',
            'experience_years' => 10,
            'qualification' => 'B.Sc Computer Science',
            'skills' => 'EasyJTAG Plus, Medusa Pro II, UFI Box, FRP Unlock, Dual-SIM Repair, Baseband Fixing',
            'bio' => 'Senior software and firmware engineer specializing in memory chip reading and forensic phone recovery.',
            'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
            'status' => true,
        ]);

        $trainer4 = Trainer::create([
            'trainer_code' => 'TRN-2026-0004',
            'name' => 'Deepak Verma',
            'mobile' => '9876543218',
            'email' => 'deepak.trainer@institute.com',
            'specialization' => 'Basic Electronics, Multimeter & Soldering',
            'experience_years' => 7,
            'qualification' => 'Diploma Electronics & Comm.',
            'skills' => 'SMD Soldering, Tracing Passive Components, Power Supplies, Oscilloscopes',
            'bio' => 'Passionate foundational instructor focused on building rock-solid electronic troubleshooting basics for freshers.',
            'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80',
            'status' => true,
        ]);

        // 7. Course Categories
        $catMobile = CourseCategory::create([
            'name' => 'Mobile Chip Level & Hardware',
            'slug' => 'mobile-chip-level',
            'icon' => 'bi-phone',
            'description' => 'Comprehensive smartphone hardware repair, tracing, and CPU reballing.',
            'status' => true,
        ]);

        $catLaptop = CourseCategory::create([
            'name' => 'Laptop Motherboard Engineering',
            'slug' => 'laptop-motherboard',
            'icon' => 'bi-laptop',
            'description' => 'Advanced laptop logic board diagnostics, power rail tracing, and BIOS reprogramming.',
            'status' => true,
        ]);

        $catSoftware = CourseCategory::create([
            'name' => 'Smartphone Software & Flashing',
            'slug' => 'smartphone-software',
            'icon' => 'bi-cpu',
            'description' => 'Unlocking, flashing, FRP bypass, IMEI repair box tools, and firmware recovery.',
            'status' => true,
        ]);

        // 8. Courses & Syllabi
        $c1 = Course::create([
            'category_id' => $catMobile->id,
            'course_name' => 'Master Mobile Chip Level & Micro-Soldering',
            'slug' => 'master-mobile-chip-level-micro-soldering',
            'course_code' => 'MCL-501',
            'level' => 'Basic to Advanced',
            'duration' => 45,
            'duration_unit' => 'Days',
            'course_fee' => 25000,
            'discount_fee' => 3000,
            'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
            'short_description' => 'Learn smartphone circuit tracing, thermal imaging diagnostics, and double-decker CPU reballing from industry experts.',
            'full_description' => 'This comprehensive 45-day practical hands-on masterclass transforms beginners and mobile technicians into master chip-level engineers. You will learn oscilloscope signal testing, schematic diagram reading with Borneo Schematics, thermal imaging fault diagnostics, power IC / charging IC replacement, and advanced micro-jumper techniques under stereomicroscopes.',
            'learning_outcomes' => "• Complete motherboard circuit tracing and voltage line identification\n• Thermal imaging camera diagnostics for dead short circuits\n• Hands-on BGA CPU and eMMC reballing without board damage\n• Troubleshooting charging, network, display, touch and audio IC faults\n• Shop management and customer device intake protocols",
            'requirements' => "• Basic interest in electronics hardware\n• No prior engineering degree required (10th / 12th / ITI eligible)",
            'featured' => true,
            'certification_available' => true,
            'status' => 'active',
        ]);

        CourseSyllabus::create([
            'course_id' => $c1->id,
            'module_number' => 1,
            'title' => 'Electronics Fundamentals & Digital Multimeter Mastery',
            'description' => 'Understanding passive and active components on logic boards.',
            'topics' => "• Resistors, capacitors, diodes, coils & transistors\n• Multimeter diode mode and continuity testing\n• Voltage injection techniques for finding leakage",
        ]);

        CourseSyllabus::create([
            'course_id' => $c1->id,
            'module_number' => 2,
            'title' => 'Schematic Tracing & Boardview Analysis',
            'description' => 'Reading Borneo, Pragmafix, and ZXW schematic diagrams.',
            'topics' => "• Power rail tracing (VBUS, VBAT, VSYS, Buck & LDO outputs)\n• PMIC startup sequence and clock signal validation\n• I2C and SPI communication bus troubleshooting with oscilloscope",
        ]);

        CourseSyllabus::create([
            'course_id' => $c1->id,
            'module_number' => 3,
            'title' => 'Advanced Micro-Soldering & BGA IC Reballing',
            'description' => 'Stereomicroscope work, jumper wire soldering, and IC rework.',
            'topics' => "• Temperature control calibration on quick hot air rework stations\n• Double-decker CPU separation, clean-up and reballing\n• Fixing broken PCB trace lines under UV mask",
        ]);

        $c2 = Course::create([
            'category_id' => $catLaptop->id,
            'course_name' => 'Advanced Laptop Motherboard & Power Rail Troubleshooting',
            'slug' => 'advanced-laptop-motherboard-troubleshooting',
            'course_code' => 'LMB-401',
            'level' => 'Advanced',
            'duration' => 30,
            'duration_unit' => 'Days',
            'course_fee' => 22000,
            'discount_fee' => 2000,
            'image' => 'https://images.unsplash.com/photo-1597740985671-2a8a3b80532e?auto=format&fit=crop&w=800&q=80',
            'short_description' => 'Master laptop motherboard repairs, 19V rail shorting, 3.3V/5V standby circuits, and BIOS reprogramming.',
            'full_description' => 'Detailed 30-day course covering laptop logic boards for Dell, HP, Lenovo, Acer, and Asus laptops. Topics include DC-in MOSFET switching, charging IC circuits, PCH/CPU power stages, S5/S3/S0 state transitions, and super I/O EC chip programming with RT809F/SVOD programmers.',
            'learning_outcomes' => "• Tracing 19V DC-in power rail and short circuit removal\n• 3.3V / 5V always-on standby circuit diagnostics\n• Super I/O (KB9012 / IT8586) flashing and pinout tracing\n• BIOS editing, ME region cleaning, and unlocking",
            'requirements' => "• Basic computer hardware awareness",
            'featured' => true,
            'certification_available' => true,
            'status' => 'active',
        ]);

        $c3 = Course::create([
            'category_id' => $catSoftware->id,
            'course_name' => 'Smartphone Software, Flashing & Box Tools',
            'slug' => 'smartphone-software-flashing-box-tools',
            'course_code' => 'SSW-301',
            'level' => 'Intermediate',
            'duration' => 20,
            'duration_unit' => 'Days',
            'course_fee' => 15000,
            'discount_fee' => 1500,
            'image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80',
            'short_description' => 'Unlock phones, flash stock firmware, fix bootloops, repair IMEI baseband, and remove FRP lock with professional box tools.',
            'full_description' => 'Comprehensive software master course utilizing UnlockTool, UMT, Miracle Box, Hydra, and Chimera Tool to solve software and bricked phone issues on Samsung, Xiaomi, Realme, Vivo, Oppo, and OnePlus phones.',
            'learning_outcomes' => "• Flashing Qualcomm (EDL Mode), MediaTek (Brom Mode) & SPD devices\n• FRP unlock, Mi Account unlock, and bootloader unlocking\n• Baseband / IMEI repair and network NVRAM restoring\n• Dead boot repair via EasyJTAG & Medusa Pro",
            'requirements' => "• Basic computer operation skills",
            'featured' => true,
            'certification_available' => true,
            'status' => 'active',
        ]);

        $c4 = Course::create([
            'category_id' => $catMobile->id,
            'course_name' => 'Apple iPhone & iPad Logic Board Specialist',
            'slug' => 'apple-iphone-ipad-logic-board-specialist',
            'course_code' => 'APL-601',
            'level' => 'Advanced',
            'duration' => 25,
            'duration_unit' => 'Days',
            'course_fee' => 28000,
            'discount_fee' => 3000,
            'image' => 'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?auto=format&fit=crop&w=800&q=80',
            'short_description' => 'Dedicated iPhone layered sandwich motherboard separation, Face ID projector repair, and NAND memory upgrade.',
            'full_description' => 'Specialized program for iPhone X to iPhone 15 Pro Max logic board repair. Master heating station separation, interposer reballing, i2C line pull-up testing, audio IC loop error fixing, and JCID programmer FaceID flex repairs.',
            'learning_outcomes' => "• Sandwich motherboard separation and bonding\n• Face ID dot projector and flood illuminator repair\n• NAND IC upgrade and EEPROM programmer tool usage\n• Tracing PP_VDD_MAIN and PP_CPU power rails",
            'requirements' => "• Completed basic mobile chip-level or 6+ months soldering experience",
            'featured' => true,
            'certification_available' => true,
            'status' => 'active',
        ]);

        // 9. Batches
        $b1 = Batch::create([
            'batch_code' => 'BAT-2026-0001',
            'course_id' => $c1->id,
            'trainer_id' => $trainer1->id,
            'batch_name' => 'March Morning Mobile Chip Level (Batch A)',
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->startOfMonth()->addDays(45),
            'start_time' => '09:30',
            'end_time' => '13:00',
            'days_schedule' => 'Monday - Saturday',
            'max_students' => 15,
            'room_number' => 'Lab 1 - Microscope Station',
            'mode' => 'Offline',
            'status' => 'Active',
        ]);

        $b2 = Batch::create([
            'batch_code' => 'BAT-2026-0002',
            'course_id' => $c2->id,
            'trainer_id' => $trainer2->id,
            'batch_name' => 'March Afternoon Laptop Motherboard (Batch B)',
            'start_date' => now()->startOfMonth(),
            'end_date' => now()->startOfMonth()->addDays(30),
            'start_time' => '14:00',
            'end_time' => '18:00',
            'days_schedule' => 'Monday - Saturday',
            'max_students' => 12,
            'room_number' => 'Lab 2 - Oscilloscope Lab',
            'mode' => 'Offline',
            'status' => 'Active',
        ]);

        // 10. Sample Students & Admissions
        $studentsData = [
            ['first_name' => 'Rahul', 'last_name' => 'Sharma', 'mobile' => '9812345670', 'email' => 'rahul.s@example.com', 'city' => 'Chennai', 'gender' => 'Male', 'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=300&q=80'],
            ['first_name' => 'Kiran', 'last_name' => 'Kumar', 'mobile' => '9812345671', 'email' => 'kiran.k@example.com', 'city' => 'Bangalore', 'gender' => 'Male', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80'],
            ['first_name' => 'Anil', 'last_name' => 'Verma', 'mobile' => '9812345672', 'email' => 'anil.v@example.com', 'city' => 'Hyderabad', 'gender' => 'Male', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80'],
            ['first_name' => 'Sanjay', 'last_name' => 'Patel', 'mobile' => '9812345673', 'email' => 'sanjay.p@example.com', 'city' => 'Coimbatore', 'gender' => 'Male', 'photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=300&q=80'],
        ];

        foreach ($studentsData as $idx => $sData) {
            $student = Student::create(array_merge($sData, [
                'student_code' => 'STU-2026-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'dob' => '2001-05-15',
                'blood_group' => 'O+',
                'address' => '15 East Street, Anna Nagar',
                'state' => 'Tamil Nadu',
                'pincode' => '600040',
                'parent_name' => 'R. ' . $sData['last_name'],
                'parent_mobile' => '987650000' . $idx,
                'qualification' => 'Diploma in Mechanical',
                'status' => 'active',
            ]));

            // Assign to batch
            $b1->students()->attach($student->id, ['assigned_date' => now()->toDateString(), 'status' => 'Active']);

            // Create Admission
            $finalFee = ($c1->course_fee) - ($c1->discount_fee);
            $initialPaid = 10000;
            $balance = $finalFee - $initialPaid;

            $adm = Admission::create([
                'admission_number' => 'ADM-2026-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'student_id' => $student->id,
                'course_id' => $c1->id,
                'batch_id' => $b1->id,
                'trainer_id' => $trainer1->id,
                'admission_date' => now()->subDays(10),
                'course_fee' => $c1->course_fee,
                'discount' => $c1->discount_fee,
                'final_fee' => $finalFee,
                'total_paid' => $initialPaid,
                'balance' => $balance,
                'payment_status' => $balance > 0 ? 'Partially Paid' : 'Paid',
                'admission_status' => 'Active',
                'source' => 'Website',
            ]);

            // Create First Payment Receipt
            Payment::create([
                'payment_code' => 'PAY-2026-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'receipt_number' => 'RCP-2026-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'admission_id' => $adm->id,
                'student_id' => $student->id,
                'amount' => $initialPaid,
                'payment_date' => now()->subDays(10),
                'payment_method' => 'UPI',
                'transaction_number' => 'UPI' . rand(100000000, 999999999),
                'collected_by' => $adminUser->id,
                'notes' => 'Admission initial seat booking payment',
            ]);

            // Installment schedule
            FeeInstallment::create([
                'admission_id' => $adm->id,
                'student_id' => $student->id,
                'installment_number' => 1,
                'due_date' => now()->subDays(10),
                'amount' => $initialPaid,
                'paid_amount' => $initialPaid,
                'balance' => 0,
                'status' => 'Paid',
            ]);

            if ($balance > 0) {
                FeeInstallment::create([
                    'admission_id' => $adm->id,
                    'student_id' => $student->id,
                    'installment_number' => 2,
                    'due_date' => now()->addDays(20),
                    'amount' => $balance,
                    'paid_amount' => 0,
                    'balance' => $balance,
                    'status' => 'Pending',
                ]);
            }

            // Attendance
            for ($d = 1; $d <= 5; $d++) {
                StudentAttendance::create([
                    'student_id' => $student->id,
                    'batch_id' => $b1->id,
                    'attendance_date' => now()->subDays($d)->toDateString(),
                    'status' => 'Present',
                    'check_in_time' => '09:28:00',
                ]);
            }
        }

        // Staff Attendance
        EmployeeAttendance::create([
            'employee_id' => $emp1->id,
            'attendance_date' => now()->toDateString(),
            'status' => 'Present',
            'check_in_time' => '08:55:00',
        ]);

        // 11. Certificates
        $cert = Certificate::create([
            'certificate_number' => 'CRT-2026-0001',
            'verification_code' => 'TM-2026-' . strtoupper(Str::random(8)),
            'student_id' => 1,
            'course_id' => $c1->id,
            'issue_date' => now(),
            'grade' => 'A+ (Distinction)',
            'status' => 'Issued',
        ]);

        // 12. CMS Content (Testimonials, FAQs, Blogs, Gallery)
        Testimonial::create([
            'name' => 'Mohamed Farooq',
            'designation' => 'Founder, Farooq Cell Solutions, Madurai',
            'rating' => 5,
            'review' => 'Best practical institute for chip level repair. Suresh Sir explained thermal imaging and double-decker CPU reballing very clearly. Today I fix dead iPhones in my own shop!',
            'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=300&q=80',
            'status' => true,
            'course_id' => $c1->id,
        ]);

        Testimonial::create([
            'name' => 'Vijay Anand',
            'designation' => 'Laptop Service Specialist, Chennai',
            'rating' => 5,
            'review' => 'The schematic tracing and oscilloscope practical training gave me immense confidence to solve 19V rail shorting and standby power drop issues.',
            'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
            'status' => true,
            'course_id' => $c2->id,
        ]);

        Testimonial::create([
            'name' => 'Karthik Raja',
            'designation' => 'Senior Hardware Engineer, Coimbatore',
            'rating' => 5,
            'review' => 'Learned iPhone sandwich motherboard separation, Face ID dot projector jumpering, and NAND upgrade within 25 days. Outstanding trainers!',
            'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
            'status' => true,
            'course_id' => $c4->id,
        ]);

        Testimonial::create([
            'name' => 'Praveen Kumar',
            'designation' => 'Owner, PK Mobile Hub, Salem',
            'rating' => 5,
            'review' => 'The software flashing and EMMC repair box training is top notch. Now unlocking FRP, flashing bricked phones, and repairing dead boots is super easy.',
            'photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=300&q=80',
            'status' => true,
            'course_id' => $c3->id,
        ]);

        Faq::create([
            'category' => 'Admissions & Batches',
            'question' => 'Do you provide practical hands-on workstations for each student?',
            'answer' => 'Yes, every trainee is allocated an individual microscope, Quick hot air rework station, digital multimeter, and practice motherboards during all lab sessions.',
            'sort_order' => 1,
            'status' => true,
        ]);

        Faq::create([
            'category' => 'Certificates',
            'question' => 'How can employers verify our course completion certificates?',
            'answer' => 'All certificates carry an authentic QR code and unique verification code that can be verified instantly on our 24/7 online verification portal.',
            'sort_order' => 2,
            'status' => true,
        ]);

        $bCatHardware = BlogCategory::create(['name' => 'Circuit Repair Guides', 'slug' => 'circuit-repair-guides', 'status' => true]);
        $bCatSoftware = BlogCategory::create(['name' => 'Software & Firmware Tips', 'slug' => 'software-firmware-tips', 'status' => true]);

        Blog::create([
            'blog_category_id' => $bCatHardware->id,
            'author_id' => $adminUser->id,
            'title' => 'How to Trace and Fix Dead Motherboard Short Circuits',
            'slug' => 'how-to-trace-and-fix-dead-motherboard-short-circuits',
            'excerpt' => 'A step-by-step diagnostic roadmap for tracing 19V laptop rails and smartphone VBUS/VBAT power shorting.',
            'content' => "When diagnosing a dead electronics board, the first step is measuring diode values with a digital multimeter across major power coils and filter capacitors.\n\n1. Visual Inspection: Check for burnt inductors or corroded ceramic capacitors under the microscope.\n2. Thermal Imaging: Connect a DC power supply with low voltage (1V) and high current (2A) to safely identify heating components.\n3. Micro-Soldering: Safely remove the shorted SMD capacitor and re-test resistance to ground before powering on the full rail.",
            'featured_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80',
            'status' => 'published',
            'published_at' => now(),
            'views_count' => 142,
            'tags' => 'motherboard, chip-level, soldering, multimeter',
        ]);

        Blog::create([
            'blog_category_id' => $bCatHardware->id,
            'author_id' => $adminUser->id,
            'title' => 'Complete Guide to BGA CPU & eMMC Reballing Temperatures',
            'slug' => 'complete-guide-to-bga-cpu-emmc-reballing-temperatures',
            'excerpt' => 'Master the exact airflow and temperature profiles for leaded and lead-free solder balls on smartphone logic boards.',
            'content' => "Reballing smartphone processor chips requires precise temperature calibration to avoid blistering PCB layers.\n\n• Pre-heating: 180°C - 200°C for 30 seconds around the IC shield.\n• IC Extraction: 330°C - 350°C with 60% airflow using bent tweezers.\n• Stencil Soldering: Low-melt 138°C or standard 183°C mechanic solder paste heated uniformly under the microscope.",
            'featured_image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
            'status' => 'published',
            'published_at' => now()->subDays(2),
            'views_count' => 285,
            'tags' => 'cpu, reballing, bga, micro-soldering',
        ]);

        Blog::create([
            'blog_category_id' => $bCatSoftware->id,
            'author_id' => $adminUser->id,
            'title' => 'Top 5 Essential Box Tools for Android Software Repair in 2026',
            'slug' => 'top-5-essential-box-tools-for-android-software-repair-2026',
            'excerpt' => 'Discover the best hardware dongles and digital credit tools for flashing Qualcomm, MTK, and Unisoc processors.',
            'content' => "Having the right toolset is crucial for any mobile repair technician handling bricked phones and network locked devices.\n\n1. UnlockTool: Leading all-in-one software for Xiaomi sideload, MTK Brom, and Samsung FRP.\n2. UMT Pro: Rock-solid for Qualcomm EDL flashing and QCN backup.\n3. EasyJTAG Plus: Hardware eMMC/UFS memory direct ISP pinout programming.",
            'featured_image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80',
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'views_count' => 320,
            'tags' => 'software, flashing, unlocktool, emmc',
        ]);

        $gCat1 = GalleryCategory::create(['name' => 'Practical Labs & Workstations', 'slug' => 'practical-labs', 'status' => true]);
        $gCat2 = GalleryCategory::create(['name' => 'Student Projects & Convocation', 'slug' => 'convocation-events', 'status' => true]);

        GalleryImage::create([
            'gallery_category_id' => $gCat1->id,
            'title' => 'Stereo Microscope Micro-Soldering Workstations',
            'image_path' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
            'description' => 'Dedicated workstation for CPU reballing and precision micro-jumper work.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat1->id,
            'title' => 'Digital Oscilloscope & Signal Generator Bench',
            'image_path' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80',
            'description' => 'Tracing I2C clock and data line waveforms across logic boards.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat1->id,
            'title' => 'Laptop Logic Board Diagnostic Lab',
            'image_path' => 'https://images.unsplash.com/photo-1597740985671-2a8a3b80532e?auto=format&fit=crop&w=800&q=80',
            'description' => 'Testing 19V power distribution rails and standby switching mosfets.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat1->id,
            'title' => 'High-Resolution Thermal Imaging Fault Finder',
            'image_path' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80',
            'description' => 'Instant detection of shorted capacitors and overheated power ICs.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat2->id,
            'title' => 'Master Batch Practical Hands-on Training',
            'image_path' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
            'description' => 'Students performing live troubleshooting under faculty guidance.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat2->id,
            'title' => 'Annual Certificate Convocation Ceremony',
            'image_path' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
            'description' => 'Celebrating our certified chip-level hardware engineers.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat2->id,
            'title' => 'iPhone Layered Motherboard Separation Bench',
            'image_path' => 'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?auto=format&fit=crop&w=800&q=80',
            'description' => 'Live practice on sandwich logic boards and Face ID repairs.',
            'status' => true,
        ]);

        GalleryImage::create([
            'gallery_category_id' => $gCat2->id,
            'title' => 'Software Box Tools & Firmware Flashing Station',
            'image_path' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80',
            'description' => 'Hands-on practice with EasyJTAG, UFI Box, and UnlockTool.',
            'status' => true,
        ]);

        // 13. Sample CRM Enquiries
        $enq1 = Enquiry::create([
            'enquiry_code' => 'ENQ-2026-0001',
            'lead_source_id' => $sourceModels[0]->id,
            'course_id' => $c1->id,
            'name' => 'Manoj Kumar',
            'mobile' => '9944556677',
            'email' => 'manoj@example.com',
            'message' => 'Interested in joining upcoming morning mobile chip level batch. Please share fee installment details.',
            'status' => 'Interested',
            'follow_up_date' => now()->addDay(),
        ]);

        FollowUp::create([
            'enquiry_id' => $enq1->id,
            'user_id' => $adminUser->id,
            'follow_up_date' => now(),
            'notes' => 'Discussed course syllabus and hostel availability. Candidate expressed strong interest to join on Monday.',
            'status' => 'Completed',
            'next_follow_up_date' => now()->addDay(),
        ]);
    }
}
