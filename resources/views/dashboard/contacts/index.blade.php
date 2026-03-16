@extends('dashboard.layouts.master')

@section('title', 'Contacts')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Contacts</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="{{ $contact->is_read ? '' : 'table-warning' }}"
                                style="{{ $contact->is_read ? '' : 'background-color: #fff3cd !important;' }}">
                                <td>{{ $contact->id }}</td>
                                <td>
                                    <strong>{{ $contact->name }}</strong>
                                    @if(!$contact->is_read)
                                        <span class="badge bg-label-danger ms-1">New</span>
                                    @endif
                                </td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone ?? 'N/A' }}</td>
                                <td>{{ $contact->subject ?? 'N/A' }}</td>
                                <td>
                                    @if($contact->is_read)
                                        <span class="badge bg-label-success">Read</span>
                                    @else
                                        <span class="badge bg-label-warning">Unread</span>
                                    @endif
                                </td>
                                <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if($contact->is_read)
                                            <form action="{{ route('admin.contacts.mark-unread', $contact->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-label-warning" title="Mark as Unread">
                                                    <i class="ti ti-mail"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.contacts.mark-read', $contact->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-label-success" title="Mark as Read">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-label-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No contacts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
@endsection
