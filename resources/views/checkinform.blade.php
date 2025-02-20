
@extends('layout.Nav')

@section('content')
<!-- rooms.html -->
<section id="rooms" class="mt-2">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <h2 class="form-title">Check-In Form</h2>
    <form action="/checkIn" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="guestName">Guest Name</label>
            <input type="text" class="form-control" id="guestName" name="guestName" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="room_id">Room Number</label>
            <select class="form-control" id="room_id" name="room_id" required>
                <option value="">Select a Room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->room_number }}">{{ $room->room_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="arrivalDate">Arrival Date</label>
            <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
        </div>
        <div class="form-group">
            <label for="departureDate">Departure Date</label>
            <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
        </div>
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="">Select a Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="cash">Cash</option>
                <option value="online">Online</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

        <div id="confirmationMessage" class="mt-4" style="display: none;">
            <h4>Check-In Confirmation</h4>
            <p id="confirmationDetails"></p>
        </div>
</section>
@endsection

