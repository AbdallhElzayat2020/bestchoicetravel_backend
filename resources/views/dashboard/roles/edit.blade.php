@extends('dashboard.layouts.master')

@section('title', 'Edit Role')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Role</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $role->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="active" {{ old('status', $role->status) == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="inactive" {{ old('status', $role->status) == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    @php
                        $rolePermissionIds = $role->permissions->pluck('id')->toArray();
                        $permissionGroups = [
                            'Main Access' => ['dashboard.access'],
                            'Bookings' => ['bookings.menu', 'bookings.manage', 'bookings.cruise-vessels.manage', 'trip-planners.manage'],
                            'Nile Cruises' => [
                                'cruise-catalog.manage',
                                'settings.manage',
                                'cruise-catalog.categories.manage',
                                'cruise-catalog.vessels.manage',
                                'cruise-catalog.programs.manage',
                            ],
                            'Tours Management' => ['categories.manage', 'sub-categories.manage', 'cruise-groups.manage', 'tours.manage', 'tour-variants.manage'],
                            'Locations' => ['locations.menu', 'countries.manage', 'states.manage'],
                            'Content Management' => [
                                'announcements.manage',
                                'faqs.manage',
                                'testimonials.manage',
                                'blogs.manage',
                                'blog-categories.manage',
                                'pages.manage',
                                'site-sections.manage',
                                'site-sections.index',
                            ],
                            'System' => ['users.manage', 'roles.manage'],
                        ];
                        $permissionsBySlug = $permissions->keyBy('slug');
                    @endphp

                    <div class="row g-3">
                        @foreach ($permissionGroups as $groupName => $slugs)
                            @php
                                $groupPermissions = collect($slugs)
                                    ->map(fn($slug) => $permissionsBySlug->get($slug))
                                    ->filter(fn($item) => $item instanceof \App\Models\Permission);
                            @endphp
                            @if ($groupPermissions->isNotEmpty())
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <h6 class="mb-3">{{ $groupName }}</h6>
                                        <div class="row">
                                            @foreach ($groupPermissions as $permission)
                                                @php
                                                    $permissionId = data_get($permission, 'id');
                                                    $permissionName = data_get($permission, 'name');
                                                    $permissionDescription = data_get($permission, 'description');
                                                @endphp
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                                            value="{{ $permissionId }}" id="permission_{{ $permissionId }}"
                                                            {{ in_array($permissionId, old('permissions', $rolePermissionIds)) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permissionId }}">
                                                            {{ $permissionName }}
                                                        </label>
                                                        @if ($permissionDescription)
                                                            <small class="d-block text-muted">{{ $permissionDescription }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @php
                            $groupedSlugs = collect($permissionGroups)->flatten()->all();
                            $remainingPermissions = $permissions->filter(
                                fn($permission) => $permission instanceof \App\Models\Permission && !in_array($permission->slug, $groupedSlugs, true),
                            );
                        @endphp
                        @if ($remainingPermissions->isNotEmpty())
                            <div class="col-12">
                                <div class="border rounded-3 p-3">
                                    <h6 class="mb-3">Other</h6>
                                    <div class="row">
                                        @foreach ($remainingPermissions as $permission)
                                            <div class="col-md-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                        {{ in_array($permission->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                    @if ($permission->description)
                                                        <small class="d-block text-muted">{{ $permission->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @error('permissions.*')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-label-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Auto-generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.value || slugInput.value === '{{ $role->slug }}') {
                slugInput.value = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
    </script>
@endpush
