@extends('layout.Nav')

@section('content')
    <section class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Transactions</h2>
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
                        <th class="border border-dark text-center align-middle">Total Amount</th>
                        <th class="border border-dark text-center align-middle">Created At</th>
                        <th class="border border-dark text-center align-middle">Updated At</th>
                        <th class="border border-dark text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="border border-dark text-center align-middle">{{ $booking->id }}</td>
                            <td class="border border-dark align-middle">
                                @php
                                    $groupedItems = [];
                                    foreach ($xitems->where('booking_id', $booking->id) as $xitem) {
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
                            <td class="border border-dark align-middle">{{ $booking->guestName }}</td>
                            <td class="border border-dark text-center align-middle">{{ $booking->rooms->room_number ?? 'N/A' }}</td>
                            <td class="border border-dark align-middle">{{ $booking->email }}</td>
                            <td class="border border-dark align-middle">{{ $booking->phone_number }}</td>
                            <td class="border border-dark text-center align-middle">{{ $booking->check_in_date }}</td>
                            <td class="border border-dark text-center align-middle">{{ $booking->check_out_date }}</td>
                            <td class="border border-dark text-end align-middle">{{ number_format($booking->total_amount) }}</td>
                            <td class="border border-dark text-center align-middle">{{ $booking->created_at }}</td>
                            <td class="border border-dark text-center align-middle">{{ $booking->updated_at }}</td>
                            <td class="border border-dark text-center align-middle">
                                <form action="/editbooking" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <button class="btn btn-secondary btn-sm me-1" style="margin-bottom: 5px" type="submit"><i class="bi bi-pencil"></i> Edit</button>
                                </form>
                                <form action="/nota" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <button class="btn btn-secondary btn-sm me-1" style="margin-bottom: 5px" type="submit"><i class="bi bi-pencil"></i>Buat Nota</button>
                                </form>
                                @if (!empty($booking->nota))
                                    <a href="{{ asset('storage/' . $booking->nota) }}" target="_blank" class="btn btn-secondary btn-sm me-1" style="margin-bottom: 5px">
                                        <i class="bi bi-pencil"></i>
                                        View Nota
                                    </a>
                                @endif
                                <form action="/deletetransaction" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking['id'] }}">
                                    <button class="btn btn-danger btn-sm" style="margin-bottom: 5px" type="submit"><i class="bi bi-trash"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center border border-dark">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
