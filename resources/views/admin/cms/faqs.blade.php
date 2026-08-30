@extends('layouts.admin')

@section('title', 'Manage FAQs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Frequently Asked Questions</h3>
        <p class="text-muted small mb-0">Manage website FAQ knowledgebase items and answers</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createFaqModal">
        <i class="bi bi-plus-circle me-1"></i> Add FAQ
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Question</th>
                    <th>Category</th>
                    <th>Answer Preview</th>
                    <th class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $f)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $f->question }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $f->category }}</span></td>
                        <td><small class="text-muted">{{ Str::limit($f->answer, 80) }}</small></td>
                        <td class="text-end pe-4">
                            <form method="POST" action="{{ route('admin.cms.faqs.destroy', $f->id) }}" onsubmit="return confirm('Delete this FAQ?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No FAQs created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Add New FAQ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.cms.faqs.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" class="form-control rounded-3" required placeholder="e.g. Admissions & Batches, Fee & Hostel, Certificates">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" class="form-control rounded-3" required placeholder="e.g. Do you provide practical demo classes?">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" class="form-control rounded-3" rows="4" required placeholder="Detailed clear response for student understanding..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
