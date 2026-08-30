@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions | Training & Admissions FAQ')

@section('content')
<x-breadcrumb title="Frequently Asked Questions (FAQ)" :breadcrumbs="['FAQ' => route('faq')]" />

<section class="py-5">
    <div class="container max-w-900 mx-auto">
        @foreach($faqs as $category => $faqList)
            <div class="mb-5">
                <h4 class="fw-bold text-primary mb-3"><i class="bi bi-patch-question-fill me-2"></i> {{ $category }}</h4>
                <div class="accordion shadow-sm rounded-4 overflow-hidden" id="faqGroup{{ Str::slug($category) }}">
                    @foreach($faqList as $fIndex => $faq)
                        <div class="accordion-item border-0 border-bottom">
                            <h3 class="accordion-header" id="heading{{ $faq->id }}">
                                <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                    {{ $faq->question }}
                                </button>
                            </h3>
                            <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqGroup{{ Str::slug($category) }}">
                                <div class="accordion-body text-muted small lh-lg bg-light">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
