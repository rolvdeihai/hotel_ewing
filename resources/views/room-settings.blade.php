@extends('layout.Nav')

@section('content')
<!-- settings.html -->
<section id="settings">
    <h2 class="mb-4">Settings</h2>
    <form action="/update-room-settings" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="room_rate" class="form-label">Price per Night</label>
            <input type="number" class="form-control" id="room_rate" name="room_rate" value="{{ $saldo->room_rate }}" required>
        </div>
        <div class="mb-3">
            <label for="tax" class="form-label">Tax Rate (%)</label>
            <input type="number" class="form-control" id="tax" name="tax" value="{{ $saldo->tax * 100 }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</section>
@endsection
