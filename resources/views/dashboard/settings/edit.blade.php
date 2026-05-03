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

                {{-- Site-wide phone (navbar, footer, etc.) --}}
                <div class="mb-4">
                    <h6 class="mb-3">Site-wide phone</h6>
                    <p class="text-muted small mb-3">Main number shown in the header, footer, and other shared areas (not
                        only the Contact Us page).</p>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone', $phone) }}" required>
                        <small class="text-muted">e.g., +20 101 515 7744 / +20 101 515 7746</small>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-4">
                    <h6 class="mb-3">Contact Us page</h6>
                    <p class="text-muted small mb-3">These values appear on the public <strong>Contact Us</strong> page
                        (email, WhatsApp, office phones, address). The contact email is also used for inbound messages
                        where the site sends notifications.</p>

                    <div class="mb-3">
                        <label for="email" class="form-label">Contact Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $email) }}" required>
                        <small class="text-muted">e.g., info@grandnilecruises.com</small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_whatsapp" class="form-label">WhatsApp Number <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('contact_whatsapp') is-invalid @enderror"
                            id="contact_whatsapp" name="contact_whatsapp"
                            value="{{ old('contact_whatsapp', $contactWhatsapp) }}" required>
                        @error('contact_whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_telephone_1" class="form-label">Telephone 1 <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('contact_telephone_1') is-invalid @enderror"
                                id="contact_telephone_1" name="contact_telephone_1"
                                value="{{ old('contact_telephone_1', $contactTelephone1) }}" required>
                            @error('contact_telephone_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact_telephone_2" class="form-label">Telephone 2</label>
                            <input type="text" class="form-control @error('contact_telephone_2') is-invalid @enderror"
                                id="contact_telephone_2" name="contact_telephone_2"
                                value="{{ old('contact_telephone_2', $contactTelephone2) }}">
                            @error('contact_telephone_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="contact_address" class="form-label">Contact Office Address <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('contact_address') is-invalid @enderror" id="contact_address" name="contact_address" rows="4"
                            required>{{ old('contact_address', $contactAddress) }}</textarea>
                        <small class="text-muted">Use each line on a new row as it should appear on Contact page.</small>
                        @error('contact_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


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
