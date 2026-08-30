@extends('layouts.admin')

@section('title', 'Master System & Institute Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Master Institute Settings</h3>
        <p class="text-muted small mb-0">Configure institute branding, contact helpline, social links, and SEO defaults</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <!-- General Info -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-building-gear me-2"></i> Institute Profile & Branding</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Institute Name <span class="text-danger">*</span></label>
                <input type="text" name="institute_name" class="form-control rounded-3" value="{{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Institute Tagline</label>
                <input type="text" name="institute_tagline" class="form-control rounded-3" value="{{ \App\Models\Setting::get('institute_tagline', 'Premier Mobile & Laptop Chip-Level Repair Academy') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Primary Contact Phone <span class="text-danger">*</span></label>
                <input type="text" name="contact_phone" class="form-control rounded-3" value="{{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Alternate / Helpline Phone</label>
                <input type="text" name="contact_phone_alt" class="form-control rounded-3" value="{{ \App\Models\Setting::get('contact_phone_alt', '+91 7418191487') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Official Email <span class="text-danger">*</span></label>
                <input type="email" name="contact_email" class="form-control rounded-3" value="{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}" required>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Campus Address</label>
                <input type="text" name="contact_address" class="form-control rounded-3" value="{{ \App\Models\Setting::get('contact_address', 'alwarthirunagar, valasaravakkam, chennai-600 087.') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Working Hours</label>
                <input type="text" name="working_hours" class="form-control rounded-3" value="{{ \App\Models\Setting::get('working_hours', 'Monday - Saturday: 9:00 AM to 7:00 PM') }}">
            </div>
        </div>

        <!-- Social Media & Messaging -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-chat-dots-fill me-2"></i> Social & Messaging Integration</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">WhatsApp Number (with country code)</label>
                <input type="text" name="whatsapp_number" class="form-control rounded-3" value="{{ \App\Models\Setting::get('whatsapp_number', '+917418191487') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Telegram Group / Channel Link</label>
                <input type="url" name="telegram_channel" class="form-control rounded-3" value="{{ \App\Models\Setting::get('telegram_channel', 'https://t.me/techmaster_circuits') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">YouTube Channel URL</label>
                <input type="url" name="youtube_url" class="form-control rounded-3" value="{{ \App\Models\Setting::get('youtube_url', 'https://youtube.com/@techmaster') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Instagram URL</label>
                <input type="url" name="instagram_url" class="form-control rounded-3" value="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com/techmaster_institute') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Facebook Page URL</label>
                <input type="url" name="facebook_url" class="form-control rounded-3" value="{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com/techmasterinstitute') }}">
            </div>
        </div>

        <!-- SEO Defaults -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-search me-2"></i> SEO & Meta Defaults</h5>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">Default Meta Title</label>
                <input type="text" name="meta_title_default" class="form-control rounded-3" value="{{ \App\Models\Setting::get('meta_title_default', 'TechMaster Training Institute | Mobile & Laptop Chip-Level Course') }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Default Meta Description</label>
                <textarea name="meta_description_default" class="form-control rounded-3" rows="2">{{ \App\Models\Setting::get('meta_description_default', 'Premier chip-level technical institute providing practical training in mobile hardware, software, oscilloscope circuit tracing, and laptop motherboard repair.') }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end pt-3 border-top">
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-check-circle-fill me-1"></i> Save Institute Settings
            </button>
        </div>
    </form>
</div>
@endsection
