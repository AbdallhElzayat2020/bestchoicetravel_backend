@extends('dashboard.layouts.master')

@section('title', 'User Dashboard')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Welcome, {{ $user->name }}</h4>
    </div>
@endsection
