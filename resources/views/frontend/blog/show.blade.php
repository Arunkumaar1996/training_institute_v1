@extends('layouts.frontend')

@section('title', $blog->seo_title ?: $blog->title)
@section('meta_description', $blog->seo_description ?: Str::limit(strip_tags($blog->content), 160))
@section('meta_keywords', $blog->seo_keywords ?: $blog->tags)

@section('content')
<x-breadcrumb :title="$blog->title" :breadcrumbs="['Blog' => route('blog'), $blog->title => route('blog.details', $blog->slug)]" />

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm rounded-4 overflow-hidden p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center gap-2 small text-muted mb-3">
                        <span class="badge bg-primary-subtle text-primary">{{ $blog->category?->name ?? 'Electronics' }}</span>
                        <span>•</span>
                        <span><i class="bi bi-calendar3 me-1"></i> {{ $blog->published_at ? $blog->published_at->format('d F Y') : 'Recent' }}</span>
                        <span>•</span>
                        <span><i class="bi bi-eye me-1"></i> {{ $blog->views_count }} Views</span>
                    </div>

                    <h1 class="fw-bold text-dark mb-4">{{ $blog->title }}</h1>

                    @if($blog->featured_image)
                        <img src="{{ $blog->featured_image }}" class="img-fluid rounded-4 mb-4 object-fit-cover w-100" style="max-height: 400px;" alt="{{ $blog->title }}">
                    @endif

                    <div class="text-dark lh-lg mb-4 fs-6">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    @if($blog->tags)
                        <div class="pt-4 border-top">
                            <strong class="small text-muted me-2">Tags:</strong>
                            @foreach(explode(',', $blog->tags) as $tag)
                                <span class="badge bg-light text-dark border me-1">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif
                </article>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">Categories</h5>
                    <ul class="list-group list-group-flush small">
                        @foreach($categories as $bCat)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                <a href="{{ route('blog', ['category' => $bCat->slug]) }}" class="text-decoration-none text-dark">{{ $bCat->name }}</a>
                                <span class="badge bg-light text-muted border rounded-pill">{{ $bCat->blogs_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">Recent Guides</h5>
                    <div class="d-flex flex-column gap-3 small">
                        @foreach($recentBlogs as $rBlog)
                            <div>
                                <a href="{{ route('blog.details', $rBlog->slug) }}" class="text-dark fw-semibold text-decoration-none d-block mb-1">{{ $rBlog->title }}</a>
                                <span class="text-muted text-xs">{{ $rBlog->published_at ? $rBlog->published_at->format('d M Y') : 'Recent' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
