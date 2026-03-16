@extends('dashboard.layouts.master')

@section('title', 'View Announcement')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">View Announcement</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-label-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.announcements.index') }}" class="btn btn-label-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2"><strong>ID:</strong></div>
                <div class="col-md-10">{{ $announcement->id }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><strong>Content:</strong></div>
                <div class="col-md-10">{{ $announcement->content }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><strong>Status:</strong></div>
                <div class="col-md-10">
                    @if($announcement->status == 'active')
                        <span class="badge bg-label-success">Active</span>
                    @else
                        <span class="badge bg-label-danger">Inactive</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><strong>Sort Order:</strong></div>
                <div class="col-md-10">{{ $announcement->sort_order }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><strong>Created At:</strong></div>
                <div class="col-md-10">{{ $announcement->created_at->format('Y-m-d H:i:s') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><strong>Updated At:</strong></div>
                <div class="col-md-10">{{ $announcement->updated_at->format('Y-m-d H:i:s') }}</div>
            </div>
        </div>
    </div>
@endsection
