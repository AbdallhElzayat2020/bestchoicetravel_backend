@extends('dashboard.layouts.master')

@section('title', 'Blog Details')

@push('css')
<style>
    body {
        background: #1a1d29;
    }
    .main-card {
        background: #1e2130;
        border: 1px solid #2a2d3a;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        overflow: hidden;
    }
    .main-card-header {
        background: linear-gradient(135deg, #1e2130 0%, #252836 100%);
        border-bottom: 1px solid #2a2d3a;
        padding: 1.5rem 2rem;
    }
    .main-card-header h5 {
        color: #e4e6eb;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .main-card-header i {
        color: #667eea;
        font-size: 1.75rem;
    }
    .main-card-body {
        background: #1a1d29;
        padding: 2rem;
    }
    .section-card {
        background: #1e2130;
        border: 1px solid #2a2d3a;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    }
    .section-header {
        background: linear-gradient(135deg, #252836 0%, #2a2d3a 100%);
        border-bottom: 1px solid #3a3d4a;
        padding: 1.25rem 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .section-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    }
    .section-header.info::before { background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); }
    .section-header.images::before { background: linear-gradient(180deg, #f093fb 0%, #f5576c 100%); }
    .section-header.seo::before { background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%); }
    .section-header.details::before { background: linear-gradient(180deg, #30cfd0 0%, #330867 100%); }
    .section-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        color: #e4e6eb;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-header i {
        font-size: 1.5rem;
        color: #667eea;
    }
    .section-header.info i { color: #667eea; }
    .section-header.images i { color: #f093fb; }
    .section-header.seo i { color: #4facfe; }
    .section-header.details i { color: #30cfd0; }
    .section-body {
        padding: 1.75rem;
        background: #1e2130;
    }
    .cover-image-container {
        background: #252836;
        border: 1px solid #3a3d4a;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 300px;
        margin-bottom: 1.5rem;
    }
    .cover-image-container img {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        border-radius: 8px;
    }
    .description-content {
        color: #b0b3b8;
        line-height: 1.8;
    }
    .description-content h1, .description-content h2, .description-content h3,
    .description-content h4, .description-content h5, .description-content h6 {
        color: #e4e6eb;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .description-content p {
        color: #b0b3b8;
        margin-bottom: 1rem;
    }
    .description-content ul, .description-content ol {
        color: #b0b3b8;
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    .description-content a {
        color: #667eea;
        text-decoration: none;
    }
    .description-content a:hover {
        text-decoration: underline;
    }
    .description-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    .description-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }
    .description-content table th,
    .description-content table td {
        border: 1px solid #3a3d4a;
        padding: 0.75rem;
        color: #b0b3b8;
    }
    .description-content table th {
        background: #252836;
        color: #e4e6eb;
    }
    .description-content blockquote {
        border-left: 4px solid #667eea;
        padding-left: 1rem;
        margin: 1rem 0;
        color: #b0b3b8;
        font-style: italic;
    }
    .description-content code {
        background: #252836;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        color: #f5576c;
        font-size: 0.9em;
    }
    .description-content pre {
        background: #252836;
        padding: 1rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1rem 0;
    }
    .description-content pre code {
        background: transparent;
        padding: 0;
        color: #e4e6eb;
    }
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: #252836;
        border-radius: 8px;
        border: 1px solid #3a3d4a;
    }
    .info-item i {
        color: #667eea;
        margin-right: 0.75rem;
        font-size: 1.2rem;
    }
    .info-item strong {
        color: #e4e6eb;
        margin-right: 0.5rem;
        min-width: 120px;
    }
    .info-item span {
        color: #b0b3b8;
    }
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card main-card">
                    <div class="card-header main-card-header d-flex justify-content-between align-items-center">
                        <h5>
                            <i class="ti ti-file-text"></i>
                            Blog Details
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-label-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit
                            </a>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-label-secondary">
                                <i class="ti ti-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body main-card-body">
                        <!-- Cover Image -->
                        @if($blog->cover_image)
                            <div class="section-card">
                                <div class="section-header images">
                                    <h6>
                                        <i class="ti ti-photo"></i>
                                        Cover Image
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="cover-image-container">
                                        <img src="{{ asset('uploads/blogs/' . $blog->cover_image) }}" alt="{{ $blog->title }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Basic Information -->
                        <div class="section-card">
                            <div class="section-header info">
                                <h6>
                                    <i class="ti ti-info-circle"></i>
                                    Basic Information
                                </h6>
                            </div>
                            <div class="section-body">
                                <div class="info-item">
                                    <i class="ti ti-heading"></i>
                                    <strong>Title:</strong>
                                    <span>{{ $blog->title }}</span>
                                </div>

                                @if($blog->author)
                                    <div class="info-item">
                                        <i class="ti ti-user"></i>
                                        <strong>Author:</strong>
                                        <span>{{ $blog->author }}</span>
                                    </div>
                                @endif

                                @if($blog->short_description)
                                    <div class="info-item">
                                        <i class="ti ti-file-text"></i>
                                        <strong>Short Description:</strong>
                                        <span>{{ $blog->short_description }}</span>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <i class="ti ti-toggle-left"></i>
                                    <strong>Status:</strong>
                                    <span>
                                        @if($blog->status == 'active')
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </span>
                                </div>



                                @if($blog->published_at)
                                    <div class="info-item">
                                        <i class="ti ti-calendar"></i>
                                        <strong>Published At:</strong>
                                        <span>{{ \Carbon\Carbon::parse($blog->published_at)->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}</span>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <i class="ti ti-sort-ascending"></i>
                                    <strong>Sort Order:</strong>
                                    <span>{{ $blog->sort_order }}</span>
                                </div>

                                <div class="info-item">
                                    <i class="ti ti-calendar-time"></i>
                                    <strong>Created At:</strong>
                                    <span>{{ \Carbon\Carbon::parse($blog->created_at)->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($blog->description)
                            <div class="section-card">
                                <div class="section-header details">
                                    <h6>
                                        <i class="ti ti-file-text"></i>
                                        Description
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="description-content">
                                        {!! $blog->description !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- SEO Information -->
                        @if($blog->meta_title || $blog->meta_description || $blog->meta_keywords)
                            <div class="section-card">
                                <div class="section-header seo">
                                    <h6>
                                        <i class="ti ti-search"></i>
                                        SEO Information
                                    </h6>
                                </div>
                                <div class="section-body">
                                    @if($blog->meta_title)
                                        <div class="info-item">
                                            <i class="ti ti-heading"></i>
                                            <strong>Meta Title:</strong>
                                            <span>{{ $blog->meta_title }}</span>
                                        </div>
                                    @endif

                                    @if($blog->meta_description)
                                        <div class="info-item">
                                            <i class="ti ti-file-text"></i>
                                            <strong>Meta Description:</strong>
                                            <span>{{ $blog->meta_description }}</span>
                                        </div>
                                    @endif

                                    @if($blog->meta_keywords)
                                        <div class="info-item">
                                            <i class="ti ti-tag"></i>
                                            <strong>Meta Keywords:</strong>
                                            <span>{{ $blog->meta_keywords }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

