@extends('layouts.frontend')

@section('title', 'Practical Lab & Institute Gallery')

@section('content')
<x-breadcrumb title="Practical Labs & Institute Gallery" :breadcrumbs="['Gallery' => route('gallery')]" />

<section class="py-5">
    <div class="container">
        <!-- Category Filter Tabs -->
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
            <a href="{{ route('gallery') }}" class="btn btn-sm rounded-pill px-3 {{ !request('category') ? 'btn-primary' : 'btn-outline-secondary' }}">All Labs</a>
            @foreach($categories as $cat)
                <a href="{{ route('gallery', ['category' => $cat->slug]) }}" class="btn btn-sm rounded-pill px-3 {{ request('category') === $cat->slug ? 'btn-primary' : 'btn-outline-secondary' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse($images as $img)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <img src="{{ $img->image_path ?: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80' }}" class="card-img-top object-fit-cover" style="height: 220px;" alt="{{ $img->title }}">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-1">{{ $img->title }}</h6>
                            <p class="text-muted small mb-0">{{ $img->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No images found in this gallery category.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $images->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection
