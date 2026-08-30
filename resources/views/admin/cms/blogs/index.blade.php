@extends('layouts.admin')

@section('title', 'Manage Blog Articles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Articles & News CMS</h3>
        <p class="text-muted small mb-0">Publish technical hardware repair guides, blog updates, and circuit tips</p>
    </div>
    <a href="{{ route('admin.cms.blogs.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> New Article
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Article</th>
                    <th>Category</th>
                    <th>Published Date</th>
                    <th>Views</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $b)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $b->featured_image ?: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=150&q=80' }}" class="rounded-3 object-fit-cover shadow-sm" style="width: 45px; height: 45px;" alt="{{ $b->title }}">
                                <div>
                                    <strong class="text-dark d-block small">{{ $b->title }}</strong>
                                    <span class="text-muted text-xs"><code>{{ $b->slug }}</code></span>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $b->category?->name ?? 'Repair Guide' }}</span></td>
                        <td class="small">{{ $b->published_at ? $b->published_at->format('d M Y') : 'Draft' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $b->views_count }} Views</span></td>
                        <td>
                            <span class="badge bg-{{ $b->status === 'published' ? 'success' : 'secondary' }} badge-chip">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.cms.blogs.edit', $b->id) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.cms.blogs.destroy', $b->id) }}" onsubmit="return confirm('Delete this blog post?');" class="d-inline ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No blog articles found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $blogs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
