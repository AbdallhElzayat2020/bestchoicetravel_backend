@extends('dashboard.layouts.master')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                    <p class="text-muted mb-0">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @include('dashboard.profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Update Password</h5>
                    <p class="text-muted mb-0">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                <div class="card-body">
                    @include('dashboard.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection
