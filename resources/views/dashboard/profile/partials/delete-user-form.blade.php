<div class="alert alert-danger">
    <h6 class="alert-heading">Danger Zone</h6>
    <p class="mb-0">Once your account is deleted, all of its resources and data will be permanently deleted. Please
        enter your password to confirm you would like to permanently delete your account.</p>
</div>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="ti ti-trash me-1"></i>
    Delete Account
</button>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to delete your account?</p>
                    <p class="text-muted small mb-3">Once your account is deleted, all of its resources and data will be
                        permanently deleted. Please enter your password to confirm you would like to permanently delete
                        your account.</p>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password"
                            name="password" placeholder="Enter your password" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
