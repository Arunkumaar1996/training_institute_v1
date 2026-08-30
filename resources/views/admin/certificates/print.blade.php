<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $certificate->certificate_number }} - {{ $certificate->student?->full_name }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800;900&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #525659;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .cert-wrapper {
            width: 1050px;
            height: 742px;
            background: #ffffff;
            position: relative;
            padding: 40px;
            border: 12px solid #1e3a8a;
            outline: 4px solid #f59e0b;
            outline-offset: -8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }
        .cert-header {
            margin-top: 10px;
        }
        .cert-title {
            font-family: 'Cinzel', serif;
            font-size: 2.3rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            color: #1e3a8a;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .cert-subtitle {
            font-size: 0.95rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #d97706;
            font-weight: 700;
        }
        .cert-body {
            padding: 10px 40px;
        }
        .cert-presented {
            font-size: 1.1rem;
            color: #4b5563;
            font-style: italic;
            margin-bottom: 8px;
        }
        .student-name {
            font-family: 'Cinzel', serif;
            font-size: 2.6rem;
            font-weight: 800;
            color: #111827;
            text-decoration: underline;
            text-decoration-color: #f59e0b;
            text-underline-offset: 8px;
            margin-bottom: 12px;
        }
        .cert-text {
            font-size: 1.15rem;
            color: #374151;
            line-height: 1.6;
            max-width: 850px;
            margin: 0 auto;
        }
        .course-name-highlight {
            font-weight: 800;
            color: #1e3a8a;
            font-size: 1.3rem;
        }
        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 40px 10px;
        }
        .signature-block {
            text-align: center;
            width: 220px;
        }
        .signature-line {
            border-bottom: 2px solid #1f2937;
            margin-bottom: 6px;
        }
        .gold-badge {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: radial-gradient(circle, #fde68a, #d97706);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #78350f;
            font-weight: 800;
            font-size: 0.75rem;
            border: 3px dashed #92400e;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .print-toolbar {
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 999;
        }
        .print-btn {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        @media print {
            body { background: transparent; padding: 0; }
            .print-toolbar { display: none; }
            .cert-wrapper {
                box-shadow: none;
                width: 100vw;
                height: 100vh;
                border-width: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <button class="print-btn" onclick="window.print()">
            <i class="bi bi-printer-fill"></i> Print Certificate (A4 Landscape)
        </button>
    </div>

    <div class="cert-wrapper">
        <!-- Header -->
        <div class="cert-header">
            <div style="font-size: 1.8rem; color: #1e3a8a; font-weight: 900; letter-spacing: 0.05em;">
                <i class="bi bi-motherboard-fill" style="color: #f59e0b;"></i> {{ \App\Models\Setting::get('institute_name', 'TECHMASTER TRAINING INSTITUTE') }}
            </div>
            <div class="cert-subtitle">Premier Electronics Hardware & Chip-Level Engineering Academy</div>
            <div class="cert-title">Certificate of Technical Mastery</div>
        </div>

        <!-- Body -->
        <div class="cert-body">
            <div class="cert-presented">This is proudly presented and certified to</div>
            <div class="student-name">{{ $certificate->student?->full_name }}</div>
            <div class="cert-text">
                for successfully completing the rigorous theoretical curriculum and practical laboratory training in
                <div class="course-name-highlight">{{ $certificate->course?->course_name }} ({{ $certificate->course?->level }})</div>
                with Grade <strong style="color: #1e3a8a; font-size: 1.25rem;">{{ $certificate->grade }}</strong>, having demonstrated high proficiency in circuit diagnostics and micro-soldering precision.
            </div>
        </div>

        <!-- Footer -->
        <div class="cert-footer">
            <div class="signature-block">
                <div class="signature-line"></div>
                <strong style="font-size: 0.85rem; color: #111827;">Lead Technical Faculty</strong>
                <div style="font-size: 0.75rem; color: #6b7280;">Department of Hardware</div>
            </div>

            <!-- Seal & Verification QR Code Info -->
            <div class="d-flex flex-column align-items-center">
                <div class="gold-badge mb-2">
                    <i class="bi bi-award-fill" style="font-size: 1.6rem; color: #78350f;"></i>
                    <span>VERIFIED</span>
                </div>
                <div style="font-size: 0.7rem; color: #4b5563; font-weight: 600;">
                    No: <strong>{{ $certificate->certificate_number }}</strong> • Issue: <strong>{{ $certificate->issue_date->format('d/m/Y') }}</strong>
                </div>
                <div style="font-size: 0.65rem; color: #9ca3af;">
                    Verify at: {{ route('certificate.verify') }}?code={{ $certificate->verification_code }}
                </div>
            </div>

            <div class="signature-block">
                <div class="signature-line"></div>
                <strong style="font-size: 0.85rem; color: #111827;">Managing Director</strong>
                <div style="font-size: 0.75rem; color: #6b7280;">TechMaster Institute</div>
            </div>
        </div>
    </div>
</body>
</html>
