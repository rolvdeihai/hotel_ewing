@extends('layout.Nav')

@section('content')
<!-- Profile Section -->
<section id="profile">
    <h2 class="mb-4">User Profile</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <p class="card-text"><strong>Name:</strong> John Doe</p>
            <p class="card-text"><strong>Email:</strong> johndoe@example.com</p>
            <p class="card-text"><strong>Phone:</strong> (123) 456-7890</p>
            <p class="card-text"><strong>Membership Status:</strong> Gold Member</p>
            <a href="/editusers" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</section>
@endsection
