

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0; /* Remove default margin */
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #343a40;
            position: fixed; /* Fixed position */
            z-index: 1000; /* High z-index to ensure it stays on top */
            width: 12%; /* Width of the navbar as a percentage */
            top: 50px; /* Start below the navbar-top */
            height: calc(100% - 50px); /* Full height minus the navbar-top height */
            align-items : flex-start;
        }

        .navbar-nav {
            display: flex; /* Use flexbox for layout */
            flex-direction: column; /* Stack items vertically */
            padding: 0; /* Remove any default padding */
            margin-top: 0; /* Ensure no margin at the top */
        }

        .nav-item {
            margin-bottom: 5%; /* Space between nav items as a percentage */
            margin-top: 5%;
            position: relative;
            display: flex;
        }

        .nav-link {
            display: block;
            width: 100%;
            padding: 5%; /* Add padding around the link text as a percentage */
            color: #ffffff; /* Text color */
            text-decoration: none; /* Remove underline */
        }

        .nav-link:hover {
            color: #adb5bd; /* Hover color */
        }

        .navbar-top {
            background-color: #343a40; /* Same color as the original navbar */
            position: fixed; /* Fixed position */
            z-index: 1000; /* High z-index to ensure it stays on top */
            top: 0;
            width: 100%;
            height: 50px; /* Height of the navbar-top */
            padding-left: 15%; /* Padding to account for the navbar width */
        }

        .navbar-top .navbar-brand,
        .navbar-top .nav-link {
            color: #ffffff; /* Text color */
        }

        .navbar-top .nav-link:hover {
            color: #adb5bd; /* Hover color */
        }

        .navbar-top-content {
           height : 50px;
        }
        .container {
            margin-top: 1%;
            margin-left: 15%; /* Space for the navbar */
            padding: 1%; /* Padding as a percentage */
            display : inline-block;
        }

        .card {
            margin-bottom: 2%; /* Margin as a percentage */
            display: flex;
        }

        .title-box {
            background-color: #495057;
            color: #ffffff;
            text-align: center;
            margin-bottom: 2%; /* Margin as a percentage */
            display: flex;
            position: relative;
        }
        .navbar .container, .navbar .container-fluid, .navbar .container-lg,
        .navbar .container-md, .navbar .container-sm, .navbar .container-xl{
            align-items : flex-start;
        }
        .nav-link{
            display: flex;
            padding-bottom : 10px;
            transition: color 0.3s ease;
        }

        .nav-link :hover{
            color: rgba(114, 113, 113, 0.7);
        }
    </style>

    </head>

<!-- Main Content -->
<div class="container mt-4" style="margin-left: 270px;">
    <!-- Content will be loaded from separate files -->
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="container">

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

</div>


</body>
</html>
