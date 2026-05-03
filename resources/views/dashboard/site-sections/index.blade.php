@extends('dashboard.layouts.master')

@section('title', isset($scope) && $scope === 'about' ? 'About Page Sections' : 'Site Sections')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-0">
                    @if(isset($scope) && $scope === 'about')
                        About Page Sections
                    @else
                        Site Sections
                    @endif
                </h4>
                <span class="text-muted small d-block">
                    @if(isset($scope) && $scope === 'about')
                        Manage About page sections from one place
                    @else
                        Manage home and page sections from one place
                    @endif
                </span>
            </div>

        </div>
        @php
            /** @var \Illuminate\Support\Collection<int, \App\Models\SiteSection> $visibleSections */
            $visibleSections = collect($sections)->reject(function (\App\Models\SiteSection $section) {
                return in_array($section->key, ['about_hero', 'about_story', 'about_why'])
                    || str_starts_with($section->key, 'contact_');
            });

            $groups = $visibleSections->groupBy(function (\App\Models\SiteSection $section) {
                if (str_starts_with($section->key, 'home_')) {
                    return 'Home Page Sections';
                }
                if (str_starts_with($section->key, 'about_')) {
                    return 'About Us Sections';
                }
                return 'Other Sections';
            });
        @endphp

        @forelse($groups as $groupTitle => $groupSections)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $groupTitle }}</h5>
                    <span class="badge bg-label-primary">{{ $groupSections->count() }} sections</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($groupSections as $section)
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="border rounded-3 h-100 p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <code>{{ $section->key }}</code>

                                    </div>
                                    <h6 class="mb-2">{{ $section->title ?: 'Untitled section' }}</h6>
                                    @if($section->subtitle)
                                        <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($section->subtitle, 70) }}</p>
                                    @else
                                        <p class="text-muted small mb-3">No subtitle</p>
                                    @endif
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.site-sections.edit', $section) }}" class="btn btn-sm btn-primary">
                                            Edit Section
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center text-muted">
                    No site sections found.
                </div>
            </div>
        @endforelse
    </div>
@endsection

