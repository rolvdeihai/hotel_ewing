@extends('layout.Nav')

@section('content')
<!-- rooms.html -->
<section id="rooms">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Rooms Management</h2>
        <a href="/roomsettings" class="btn btn-secondary" style="font-size: 1.5rem">
            <i class="fas fa-cog"></i> <!-- Settings icon -->
        </a>
    </div>
    <div class="row">
        @foreach ($rooms as $r)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Room {{$r->room_number}}</h5>
                        <p class="card-text">Status: {{$r->status}}</p>
                        <p class="card-text">Guest: {{$r->name}}</p>
                        @if($r->status == 'vacant')
                            <a href="/checkin" class="btn btn-primary">Check In</a>

                        @elseif($r->status == 'occupied')
                            <form action="/checkout" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="room_id" value="{{$r->room_number}}">
                                <button class="btn btn-primary" style="margin-bottom: 5px" type="submit">Checkout</button>
                            </form>
                            {{-- <a href="/additionalitem" class="btn btn-secondary">additional Item</a> --}}
                            <form action="/additionalitem" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="room_id" value="{{$r->room_number}}">
                                <button class="btn btn-secondary" style="margin-bottom: 5px" type="submit">Additional Item</button>
                            </form>
                            <form action="/booking" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="room_id" value="{{$r->room_number}}">
                                <button class="btn btn-success" style="margin-bottom: 5px" type="submit">Booking</button>
                            </form>
                            {{-- <a href="/booking" class="btn btn-success">Booking</a> --}}

                        @else
                            <a href="#" class="btn btn-primary">Maintenance</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        {{-- <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Room 102</h5>
                    <p class="card-text">Status: Vacant</p>
                    <a href="#" class="btn btn-success">Check In</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Room 103</h5>
                    <p class="card-text">Status: Maintenance</p>
                    <a href="#" class="btn btn-warning">Under Maintenance</a>
                </div>
            </div>
        </div> --}}
    </div>
</section>
@endsection
