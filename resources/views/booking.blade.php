@extends('layout.Nav')

@section('content')
    <section class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Booked Rooms</h2>
            
        </div>

        <div class="table-responsive">
            <table class="table table-bordered border-dark">
                <thead>
                    <tr class="table-light">
                        <th class="border border-dark text-center align-middle">ID</th>
                        <th class="border border-dark text-center align-middle">Additional Items</th>
                        <th class="border border-dark text-center align-middle">Guest Name</th>
                        <th class="border border-dark text-center align-middle">Room Number</th>
                        <th class="border border-dark text-center align-middle">Email</th>
                        <th class="border border-dark text-center align-middle">Phone Number</th>
                        <th class="border border-dark text-center align-middle">Check In Date</th>
                        <th class="border border-dark text-center align-middle">Check Out Date</th>
                        <th class="border border-dark text-center align-middle">Room Rate</th>
                        <th class="border border-dark text-center align-middle">Created At</th>
                        <th class="border border-dark text-center align-middle">Updated At</th>
                        <th class="border border-dark text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
    
                    <tr>
                        <td class="border border-dark text-center align-middle">{{ $bookings['id'] }}</td>
                        <td class="border border-dark align-middle">
                            @php
                                $groupedItems = [];
                                foreach ($xitems as $xitem) {
                                    $name = $xitem->pricelists->name;
                                    if (!isset($groupedItems[$name])) {
                                        $groupedItems[$name] = 0;
                                    }
                                    $groupedItems[$name] += $xitem->qty;
                                }
                            @endphp
                            <ul>
                                @foreach ($groupedItems as $name => $qty)
                                    <li>{{ $name }} x{{ $qty }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border border-dark align-middle">{{ $bookings['guestName'] }}</td>
                        <td class="border border-dark text-center align-middle">{{ $bookings->rooms->room_number }}</td>
                        <td class="border border-dark align-middle">{{ $bookings['email'] }}</td>
                        <td class="border border-dark align-middle">{{ $bookings['phone_number'] }}</td>
                        <td class="border border-dark text-center align-middle">{{ $bookings['check_in_date'] }}</td>
                        <td class="border border-dark text-center align-middle">{{ $bookings['check_out_date'] }}</td>
                        <td class="border border-dark text-end align-middle">{{ number_format($bookings['room_rate']) }}</td>
                        <td class="border border-dark text-center align-middle">{{ $bookings['created_at'] }}</td>
                        <td class="border border-dark text-center align-middle">{{ $bookings['updated_at'] }}</td>
                        <td class="border border-dark text-center align-middle">
                            {{-- <a href="/editbooking" class="btn btn-secondary btn-sm me-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a> --}}
                            <form action="/editbooking" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $bookings['id'] }}">
                                <button class="btn btn-secondary btn-sm me-1" style="margin-bottom: 5px" type="submit"><i class="bi bi-pencil"></i>Edit</button>
                            </form>
                            <form action="/deletebooking" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $bookings['id'] }}">
                                <button class="btn btn-danger btn-sm" style="margin-bottom: 5px" type="submit"><i class="bi bi-trash"></i>Delete</button>
                            </form>
                            {{-- <a href="/deletebooking/{{ $bookings['id'] }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </a> --}}
                        </td>
                    </tr>

                    @if(empty($bookings))
                        <tr>
                            <td colspan="11" class="text-center border border-dark">No bookings found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>



@endsection
