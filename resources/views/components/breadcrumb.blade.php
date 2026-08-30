@props(['title', 'breadcrumbs' => []])

<nav aria-label="breadcrumb" class="bg-light py-3 border-bottom mb-4">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="h4 fw-bold text-dark mb-0">{{ $title }}</h1>
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door-fill text-primary"></i> Home</a></li>
            @foreach($breadcrumbs as $label => $url)
                @if($loop->last)
                    <li class="breadcrumb-item active fw-semibold" aria-current="page">{{ $label }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $url }}" class="text-decoration-none">{{ $label }}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>
