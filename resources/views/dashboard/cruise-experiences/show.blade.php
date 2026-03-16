@extends('dashboard.layouts.master')

@section('title', 'Dahbia Cruise Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Cruise Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.cruise-experiences.edit', $experience->id) }}" class="btn btn-label-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.cruise-experiences.index') }}" class="btn btn-label-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    @if($experience->images->count())
                        <h6 class="mb-3">Gallery</h6>
                        @php
                            $coverImage = $experience->images->first()
                                ? asset('uploads/cruise-experiences/' . $experience->images->first()->image)
                                : asset('assets/frontend/assets/images/destination-01.png');
                            $firstImage = $experience->images->first();
                            $mainImage = $firstImage ? asset('uploads/cruise-experiences/' . $firstImage->image) : $coverImage;
                            // Get side images (skip first one if it's used as main)
                            $sideImages = $experience->images->skip(1)->take(2);
                        @endphp
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-lg-8">
                                <a data-fancybox="cruise-gallery" href="{{ $mainImage }}" class="d-block">
                                    <img src="{{ $coverImage }}" alt="{{ $experience->title }}"
                                        class="img-fluid rounded" style="width: 100%; height: 360px; object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="d-flex flex-column gap-3" style="max-height: 360px; overflow-y: auto;">
                                    @if($sideImages->count() > 0)
                                        @foreach($sideImages as $index => $image)
                                            <a data-fancybox="cruise-gallery" href="{{ asset('uploads/cruise-experiences/' . $image->image) }}" class="d-block">
                                                <img src="{{ asset('uploads/cruise-experiences/' . $image->image) }}"
                                                    alt="Image {{ $index + 2 }}"
                                                    class="img-fluid rounded" style="width: 100%; height: 170px; object-fit: cover;">
                                            </a>
                                        @endforeach
                                    @endif
                                    @if($experience->images->count() > 3)
                                        <div class="position-relative">
                                            <a data-fancybox="cruise-gallery"
                                                href="{{ asset('uploads/cruise-experiences/' . $experience->images->skip(3)->first()->image) }}"
                                                class="d-block">
                                                <img src="{{ asset('uploads/cruise-experiences/' . $experience->images->skip(3)->first()->image) }}"
                                                    alt="Image 4"
                                                    class="img-fluid rounded" style="width: 100%; height: 170px; object-fit: cover;">
                                            </a>
                                            @if($experience->images->count() > 4)
                                                <a href="{{ asset('uploads/cruise-experiences/' . $experience->images->skip(4)->first()->image) }}"
                                                    data-fancybox="cruise-gallery"
                                                    class="btn btn-sm btn-white position-absolute bottom-2 end-2 shadow-sm text-decoration-none">
                                                    <i class="ti ti-grid-dots me-1"></i>
                                                    Gallery
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Add all images to Fancybox gallery (hidden links for navigation) --}}
                        @foreach($experience->images as $image)
                            <a data-fancybox="cruise-gallery" href="{{ asset('uploads/cruise-experiences/' . $image->image) }}" style="display: none;"></a>
                        @endforeach
                    @endif

                    @if($experience->description)
                        <h6 class="mb-2">Program Content</h6>
                        <div class="border rounded p-3 mb-4" style="background-color: #f8f9fa;">
                            <div class="description-content">
                                {!! $experience->description !!}
                            </div>
                        </div>
                    @endif

                    @if($experience->tours->count())
                        <h6 class="mb-2">Related Tours</h6>
                        <div class="row g-3 mb-2">
                            @foreach($experience->tours as $tour)
                                @php
                                    $cover = $tour->cover_image
                                        ? asset('uploads/tours/' . $tour->cover_image)
                                        : asset('assets/frontend/assets/images/destination-01.png');
                                    $price = $tour->current_price ?? $tour->price;
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0"
                                        style="overflow: hidden; border-radius: 12px; background: #1e2130; box-shadow: 0 6px 18px rgba(0,0,0,0.45);">
                                        <div style="height: 160px; overflow: hidden; position: relative;">
                                            <img src="{{ $cover }}" alt="{{ $tour->title }}"
                                                style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.9);">
                                            <span class="badge bg-label-success position-absolute top-2 start-2"
                                                style="backdrop-filter: blur(4px);">
                                                ${{ number_format($price, 2) }}
                                            </span>
                                        </div>
                                        <div class="card-body d-flex flex-column" style="background: #1e2130;">
                                            <h6 class="card-title mb-2" style="font-weight: 600; color: #e4e6eb;">
                                                {{ \Illuminate\Support\Str::limit($tour->title, 60) }}
                                            </h6>
                                            @if($tour->short_description)
                                                <p class="card-text mb-2" style="font-size: 0.875rem; color:#b0b3b8;">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($tour->short_description), 90) }}
                                                </p>
                                            @endif
                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <a href="{{ route('admin.tours.show', $tour->id) }}"
                                                    class="btn btn-sm btn-label-primary">
                                                    <i class="ti ti-eye me-1"></i>
                                                    View Tour
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <h6 class="mb-3">Basic Information</h6>
                    <table class="table table-sm">
                        <tr>
                            <th style="width: 140px;">Title</th>
                            <td>{{ $experience->title }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $experience->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($experience->status === 'active')
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>{{ $experience->sort_order }}</td>
                        </tr>
                        @if($experience->short_description)
                            <tr>
                                <th>Short Description</th>
                                <td>{{ $experience->short_description }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Created At</th>
                            <td>{{ $experience->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $experience->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    </table>

                    @if($experience->meta_title || $experience->meta_description || $experience->meta_keywords)
                        <h6 class="mt-4 mb-3">SEO</h6>
                        <table class="table table-sm">
                            @if($experience->meta_title)
                                <tr>
                                    <th style="width: 140px;">Meta Title</th>
                                    <td>{{ $experience->meta_title }}</td>
                                </tr>
                            @endif
                            @if($experience->meta_description)
                                <tr>
                                    <th>Meta Description</th>
                                    <td>{{ $experience->meta_description }}</td>
                                </tr>
                            @endif
                            @if($experience->meta_keywords)
                                <tr>
                                    <th>Meta Keywords</th>
                                    <td>{{ $experience->meta_keywords }}</td>
                                </tr>
                            @endif
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Fancybox.bind("[data-fancybox='cruise-gallery']", {
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["slideshow", "download", "thumbs", "close"],
                    },
                },
            });
        });
    </script>
@endpush
