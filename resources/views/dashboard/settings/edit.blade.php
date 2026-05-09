@extends('dashboard.layouts.master')

@section('title', 'Settings')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Website Settings</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Navbar Settings --}}
                <div class="mb-4">
                    <h6 class="mb-3">Navbar Settings</h6>

                    <div class="mb-3">
                        <label for="main_cruises_menu_name" class="form-label">Main Cruises Menu Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('main_cruises_menu_name') is-invalid @enderror"
                            id="main_cruises_menu_name" name="main_cruises_menu_name"
                            value="{{ old('main_cruises_menu_name', $mainCruisesMenuName) }}" required>
                        <small class="text-muted">This is the navbar link label (e.g. Nile Cruises).</small>
                        @error('main_cruises_menu_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="navbar_logo" class="form-label">Navbar Logo</label>
                        @if ($navbarLogo)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/settings/' . $navbarLogo) }}" alt="Navbar Logo"
                                    style="max-width: 200px; max-height: 80px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('navbar_logo') is-invalid @enderror"
                            id="navbar_logo" name="navbar_logo" accept="image/*">
                        <small class="text-muted">Leave empty to keep current logo. Recommended size: 200x60px</small>
                        @error('navbar_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                </div>

                <hr class="my-4">


                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-label-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
