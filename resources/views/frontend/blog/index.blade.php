@extends('layouts.frontend')

@section('title', 'Technical Blog & Circuit Repair Guides')

@section('content')
<x-breadcrumb title="Technical Blog & Hardware Guides" :breadcrumbs="['Blog' => route('blog')]" />

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left: Blog Posts -->
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($blogs as $blog)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column">
                                <img src="{{ $blog->featured_image ?: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80' }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $blog->title }}">
                                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 small text-muted mb-2">
                                        <span class="badge bg-primary-subtle text-primary">{{ $blog->category?->name ?? 'Repair Guide' }}</span>
                                        <span>•</span>
                                        <span><i class="bi bi-calendar3 me-1"></i> {{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Recent' }}</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">
                                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none text-dark">{{ $blog->title }}</a>
                                    </h5>
                                    <p class="text-muted small mb-4 flex-grow-1">{{ $blog->excerpt ?: Str::limit(strip_tags($blog->content), 100) }}</p>
                                    <a href="{{ route('blog.details', $blog->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 align-self-start mt-auto">Read Full Guide <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No articles found matching your criteria.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- Right Sidebar: Categories & Recent Posts -->
            <div class="col-lg-4">
                <!-- Search Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">Search Blog</h5>
                    <form method="GET" action="{{ route('blog') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search articles...">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
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

                <!-- Recent Posts -->
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
