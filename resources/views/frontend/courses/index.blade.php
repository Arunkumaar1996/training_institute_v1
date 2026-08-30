@extends('layouts.frontend')

@section('title', 'All Technical Courses | Mobile & Laptop Chip Level')
@section('meta_description', 'Explore practical training courses for Mobile Hardware, Software, Chip Level IC, and Laptop Motherboard repair.')

@section('content')
<x-breadcrumb title="Explore Our Technical Training Courses" :breadcrumbs="['Courses' => route('courses')]" />

<section class="py-4">
    <div class="container">
        <!-- Search and Filter Controls -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
            <form id="courseFilterForm" method="GET" action="{{ route('courses') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 bg-light" id="searchCourse" name="search" value="{{ request('search') }}" placeholder="Search course by name, topic, or code...">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="form-select bg-light" name="category" id="filterCategory">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }} ({{ $cat->courses_count }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="form-select bg-light" name="level" id="filterLevel">
                            <option value="">All Skill Levels</option>
                            <option value="Basic" {{ request('level') == 'Basic' ? 'selected' : '' }}>Basic</option>
                            <option value="Intermediate" {{ request('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                            <option value="Basic to Advanced" {{ request('level') == 'Basic to Advanced' ? 'selected' : '' }}>Basic to Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary rounded-3"><i class="bi bi-funnel-fill"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Course List Container -->
        <div id="courseAjaxTarget">
            @include('frontend.courses._course_grid', ['courses' => $courses])
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let debounceTimer;
        function fetchFilteredCourses() {
            const formData = $('#courseFilterForm').serialize();
            $.ajax({
                url: "{{ route('courses') }}",
                type: "GET",
                data: formData,
                beforeSend: function() {
                    $('#courseAjaxTarget').css('opacity', '0.5');
                },
                success: function(html) {
                    $('#courseAjaxTarget').html(html).css('opacity', '1');
                },
                error: function() {
                    $('#courseAjaxTarget').css('opacity', '1');
                }
            });
        }

        $('#searchCourse').on('keyup', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchFilteredCourses, 350);
        });

        $('#filterCategory, #filterLevel').on('change', function() {
            fetchFilteredCourses();
        });
    });
</script>
@endpush
