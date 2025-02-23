@extends('layout.Nav')

@section('content')
<!-- Profile Section -->
<section id="profile">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2 class="mb-4">User Profiles</h2>

    @foreach($users as $user)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <p class="card-text"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Role:</strong> {{ $user->role }}</p>
            {{-- <a href="#" class="btn btn-primary">Edit Profile</a> --}}
            <form action="/editAccount" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="users_id" value="{{ $user['id'] }}">
                <button class="btn btn-primary" type="submit">Edit</button>
            </form>
        </div>
    </div>
    @endforeach

</section>
@endsection
