@extends('layout.Nav')

@section('content')
<!-- Profile Section -->
<section id="profile">
    <h2 class="mb-4">User Profile</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <p class="card-text"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Role:</strong> {{ $user->role }}</p>
            {{-- <a href="#" class="btn btn-primary">Edit Profile</a> --}}
        </div>
    </div>
</section>
@endsection
