@extends('dashboard.layouts.master')

@section('title', 'Contact Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Contact Details</h5>
            <div class="d-flex gap-2">
                @if($contact->is_read)
                    <form action="{{ route('admin.contacts.mark-unread', $contact->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-mail me-1"></i>
                            Mark as Unread
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.contacts.mark-read', $contact->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-1"></i>
                            Mark as Read
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert {{ $contact->is_read ? 'alert-success' : 'alert-warning' }}" role="alert">
                        <strong>Status:</strong>
                        @if($contact->is_read)
                            <span class="badge bg-label-success">Read</span>
                            @if($contact->read_at)
                                <span class="ms-2">Read at: {{ $contact->read_at->format('Y-m-d H:i:s') }}</span>
                            @endif
                        @else
                            <span class="badge bg-label-warning">Unread</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <p class="form-control-plaintext">{{ $contact->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p class="form-control-plaintext">
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Phone</label>
                    <p class="form-control-plaintext">
                        @if($contact->phone)
                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Subject</label>
                    <p class="form-control-plaintext">{{ $contact->subject ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <p class="form-control-plaintext">
                        @if($contact->category)
                            <span class="badge bg-label-info">{{ $contact->category->name }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Sub Category</label>
                    <p class="form-control-plaintext">
                        @if($contact->subCategory)
                            <span class="badge bg-label-secondary">{{ $contact->subCategory->name }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <div class="card bg-label-secondary p-3">
                        <p class="mb-0">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="form-control-plaintext">{{ $contact->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Updated At</label>
                    <p class="form-control-plaintext">{{ $contact->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this contact?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Delete Contact
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

