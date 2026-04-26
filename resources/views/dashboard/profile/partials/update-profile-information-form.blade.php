<form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="profile_image" class="form-label">Profile Image</label>
            <div class="d-flex align-items-center gap-3 mb-2">
                <img src="{{ $user->profileImageUrl() }}" alt="{{ $user->name }}"
                    class="rounded-circle border" style="width:64px;height:64px;object-fit:cover;">
                <div>
                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                        id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">Allowed: JPG, PNG, WEBP (max 2MB)</small>
                    @error('profile_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-muted">
                        Your email address is unverified.
                        <a href="{{ route('verification.send') }}" class="text-primary">
                            Click here to re-send the verification email.
                        </a>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-success">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i>
            Save Changes
        </button>
    </div>
</form>
