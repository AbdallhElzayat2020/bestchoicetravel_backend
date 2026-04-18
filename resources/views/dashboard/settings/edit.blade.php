@extends('dashboard.layouts.master')

@section('title', 'Settings')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Website Settings</h5>
        </div>
        <div class="card-body">
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
                        <small class="text-muted">This is the navbar link label (e.g. Dahabiya & Cruises).</small>
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

                {{-- Contact Information --}}
                {{-- <div class="mb-4">
                    <h6 class="mb-3">Contact Information</h6>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', $phone) }}" required>
                        <small class="text-muted">e.g., +20 101 515 7744 / +20 101 515 7746</small>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $email) }}" required>
                        <small class="text-muted">e.g., info@grandnilecruises.com</small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                            required>{{ old('address', $address) }}</textarea>
                        <small class="text-muted">Full address for footer</small>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}


                {{-- Footer Logo --}}
                {{-- <div class="mb-4">
                    <h6 class="mb-3">Footer Logo</h6>
                    <div class="mb-3">
                        <label for="footer_logo" class="form-label">Footer Logo</label>
                        @if ($footerLogo)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/settings/' . $footerLogo) }}" alt="Footer Logo"
                                    style="max-width: 200px; max-height: 80px; border-radius: 4px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('footer_logo') is-invalid @enderror"
                            id="footer_logo" name="footer_logo" accept="image/*">
                        <small class="text-muted">Leave empty to keep current logo. Recommended size: 200x60px</small>
                        @error('footer_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}

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
