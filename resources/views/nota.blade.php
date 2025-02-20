@extends('layout.Nav')

@section('content')

<?php
use Carbon\Carbon;

// Data untuk guest
$guest = [
    'name' => $bookings->guestName,
    'email' => $bookings->email,
    'phone_number' => $bookings->phone_number,
];

// Data untuk transaksi
$room_rate = $saldo->room_rate;

$check_in = Carbon::parse($bookings->check_in_date);
$check_out = Carbon::parse($bookings->check_out_date);
$nights = $check_in->diffInDays($check_out);

$room_total = $room_rate * $nights;
$tax_rate = $saldo->tax_rate;
$tax = $bookings->total_amount * $tax_rate;
$total = $bookings->total_amount + $tax;

$transaction = [
    'transaction_id' => 'INV-' . $bookings->id,
    'date' => $bookings->check_out_date,
    'check_in_date' => $bookings->check_in_date,
    'check_out_date' => $bookings->check_out_date,
    'room_number' => $bookings->rooms->room_number,
    'nights' => $nights,
    'room_rate' => $room_rate,
    'room_total' => $room_total,
    'payment_method' => $bookings->payment_method,
    'additional_charges' => $xitems->map(function ($item) {
        return [
            'item' => $item->pricelists->name,
            'quantity' => $item->qty,
            'price' => $item->pricelists->price,
            'total' => $item->qty * $item->pricelists->price,
        ];
    }),
    'subtotal' => $bookings->total_amount,
    'tax' => $tax,
    'total' => $total,
];
?>

<section class="container-fluid py-4">
    <div class="text-center mb-4">
        <h1>INVOICE</h1>
        <p>Number: {{ $transaction['transaction_id'] }}</p>
        <p>Date: {{ $transaction['date'] }}</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h5>CUSTOMER DETAIL</h5>
            <p><b>Name:</b> {{ $guest['name'] }}</p>
            <p><b>Email:</b> {{ $guest['email'] }}</p>
            <p><b>Phone:</b> {{ $guest['phone_number'] }}</p>
        </div>
        <div class="col-md-6 text-end">
            <h5>PAYMENT DETAIL</h5>
            <p><b>Payment Method:</b> {{ $transaction['payment_method'] }}</p>
            <p><b>Status:</b> Lunas</p>
        </div>
    </div>

    <h5>PURCHASE DETAIL</h5>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>No</th>
                <th>Item Description</th>
                <th>Qty</th>
                <th>Price (Rp)</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Room {{ $transaction['room_number'] }} - {{ $transaction['nights'] }} night(s)</td>
                <td>{{ $transaction['nights'] }}</td>
                <td>{{ number_format($transaction['room_rate']) }}</td>
                <td>{{ number_format($transaction['room_total']) }}</td>
            </tr>
            @foreach ($transaction['additional_charges'] as $index => $charge)
                <tr>
                    <td>{{ $index + 2 }}</td>
                    <td>{{ $charge['item'] }}</td>
                    <td>{{ $charge['quantity'] }}</td>
                    <td>{{ number_format($charge['price']) }}</td>
                    <td>{{ number_format($charge['total']) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><b>Subtotal:</b></td>
                <td>{{ number_format($transaction['subtotal']) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>Tax (15%):</b></td>
                <td>{{ number_format($transaction['tax']) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><b>Total:</b></td>
                <td><b>{{ number_format($transaction['total']) }}</b></td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mt-4">
        <a href="{{ asset('storage/' . $bookings->nota) }}" target="_blank" class="btn btn-primary">Download Invoice</a>
    </div>
</section>



<style>
    h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }
    h5 {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }
    .table {
        border-collapse: collapse;
        width: 100%;
    }
    .table th, .table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    .table th {
        background-color: #f2f2f2;
    }
    .text-right {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }
</style>
@endsection
