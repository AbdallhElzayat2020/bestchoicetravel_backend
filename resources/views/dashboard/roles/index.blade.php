@extends('dashboard.layouts.master')

@section('title', 'Roles')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Roles</h5>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New
            </a>
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

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Users Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-label-info">{{ $role->users_count }}</span>
                                </td>
                                <td>
                                    @if ($role->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        @if ($role->slug !== 'admin')
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-label-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No roles found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection


{{--

1- اضيف  الكاتوجري
2- بعدين اضيف الرحلات التابعة بالمراكب دي رحلات من اول وجديد   وبتقي من غير صور #
3- بضيف المراكب وبعدين بشاور  عل الرحلات التابعة ليها  وبتتعرض الرحلات جوا المركب في بيانات المركب
وتغير السعر بيبقي حسب الرحلة

هو التور بقا بتاع المراكب بتحتوي علي الاسم ولايام بتاعتة

وبيبقي جوا كل مركب 3 اسعار  السعر علي مركب 1 والسعر علي مركب 2  و السعر علي مركب 3
    Nile Cruises Category

    [   'Cruises',
        'Dahabiya',
    ]


    Tours




    Tailor Made Tours
    الفرومة
الاسم الكامل
الجنسية كتابة
التلفون
الايمال

عدد الاشخاص   مقسمة ل عدد الكبار والاطفال والرضيع
Arrival Date Adults (+12 years)
Departure Date  Children (2 to 11)
Infants (0 to 2)

المسدج
    --}}
