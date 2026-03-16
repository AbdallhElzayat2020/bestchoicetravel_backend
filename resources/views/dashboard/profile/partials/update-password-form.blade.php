<form method="post" action="{{ route('admin.profile.password.update') }}">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
            <input type="password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                id="current_password" name="current_password" required autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                id="password" name="password" required autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password <span
                    class="text-danger">*</span></label>
            <input type="password"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-key me-1"></i>
            Update Password
        </button>
    </div>
</form>
