<?php
use Carbon\Carbon;

// Data untuk guest
$guest = [
    'name' => $bookings->guestName,
    'email' => $bookings->email,
    'phone_number' => $bookings->phone_number,
];

// Data untuk transaksi
$room_rate = $bookings->room_rate;

$check_in = Carbon::parse($bookings->check_in_date);
$check_out = Carbon::parse($bookings->check_out_date);
$hours = $check_in->diffInHours($check_out);
// if ($nights < 1){
//     $nights = 1;
// }

$nights = ceil($hours/24);
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
    'room_total' => $room_rate * $nights,
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
<!-- Hotel Invoice Template - Landscape -->
<div class="container-landscape">
    <div class="header-row">
        <div class="logo-container">
            <img src="/storage/image/hotel-logo.png" alt="Hotel Logo" class="logo">
        </div>
        <div class="hotel-info">
            <h2>HOTEL DWIPA WISATA</h2>
            <p>Jl. Yos Sudarso, Ikan Tembakang No. 2-B</p>
            <p>TELP. (0721) 482722 - 485306 Bandar Lampung</p>
        </div>
    </div>

    <div class="customer-details">
        <table class="info-table">
            <tr>
                <td width="15%"><strong>NAMA:</strong></td>
                <td width="35%">{{ $guest['name'] }}</td>
                <td width="15%"><strong>PAYMENT:</strong></td>
                <td width="35%">{{ $transaction['payment_method'] }}</td>
            </tr>
            <tr>
                <td><strong>EMAIL:</strong></td>
                <td>{{ $guest['email'] }}</td>
                <td><strong>STATUS:</strong></td>
                <td>Lunas</td>
            </tr>
            <tr>
                <td><strong>TELP:</strong></td>
                <td>{{ $guest['phone_number'] }}</td>
                <td><strong>LEMBAR KE:</strong></td>
                <td>{{ $transaction['transaction_id'] }}</td>
            </tr>
        </table>
    </div>

    <div class="form-container">
        <table class="receipt-table">
            <!-- TRANSAKSI -->
            <tr>
                <td class="section-header" colspan="4">TRANSAKSI</td>
            </tr>
            <tr>
                <td width="40%">TANGGAL</td>
                <td width="60%">: {{ $bookings->check_out_date }}</td>
            </tr>
            <tr>
                <td>KAMAR</td>
                <td>: {{ $bookings->rooms->room_number }}</td>
            </tr>

            <!-- CAFETARIA -->
            <tr>
                <td class="section-header" colspan="4">ITEM TAMBAHAN</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="inner-table">
                        <tr>
                            <th width="40%">Item</th>
                            <th width="20%">Qty</th>
                            <th width="20%">Price</th>
                            <th width="20%">Total</th>
                        </tr>
                        @forelse ($transaction['additional_charges'] as $charge)
                        <tr>
                            <td>{{ $charge['item'] }}</td>
                            <td class="text-center">{{ $charge['quantity'] }}</td>
                            <td class="text-right">{{ number_format($charge['price']) }}</td>
                            <td class="text-right">{{ number_format($charge['total']) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center"></td>
                        </tr>
                        @endforelse
                    </table>
                </td>
            </tr>

            <!-- BINTITI LAUNDRY -->
            <tr>
                <td class="section-header" colspan="4">BINTITI LAUNDRY</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="inner-table">
                        <tr>
                            <th width="40%">Item</th>
                            <th width="20%">Qty</th>
                            <th width="20%">Price</th>
                            <th width="20%">Total</th>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center"></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- PERMANENT/TEAM -->
            <tr>
                <td class="section-header" colspan="4">PERINCIAN/ITEM</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="inner-table">
                        <tr>
                            <th width="40%">Item</th>
                            <th width="20%">Qty</th>
                            <th width="20%">Price</th>
                            <th width="20%">Total</th>
                        </tr>
                        <tr>
                            <td>Room {{ $transaction['room_number'] }} - {{ $transaction['nights'] }} night(s)</td>
                            <td class="text-center">{{ $transaction['nights'] }}</td>
                            <td class="text-right">{{ number_format($transaction['room_rate']) }}</td>
                            <td class="text-right">{{ number_format($transaction['room_total']) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- LAIN-LAIN -->
            <tr>
                <td class="section-header" colspan="4">LAIN-LAIN</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="inner-table">
                        <tr>
                            <th width="40%">Item</th>
                            <th width="20%">Qty</th>
                            <th width="20%">Price</th>
                            <th width="20%">Total</th>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center"></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- JUMLAH AMOUNT -->
            <tr>
                <td class="jumlah-amount-header" style="font-size :11pt" colspan="4">JUMLAH AMOUNT</td>
            </tr>
            <tr>
                <td colspan="2">Subtotal:</td>
                <td colspan="2" class="text-right">{{ number_format($transaction['subtotal']) }}</td>
            </tr>
            <tr>
                <td colspan="2">Tax ({{ $tax_rate * 100 }}%):</td>
                <td colspan="2" class="text-right">{{ number_format($transaction['tax']) }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>TOTAL:</strong></td>
                <td colspan="2" class="total-amount text-right" style="font-size: 12pt">{{ number_format($transaction['total']) }}</td>
            </tr>
        </table>
    </div>

    <div class="signatures">
        <table class="sign-table">
            <tr>
                <td width="40%">
                    <p>TANDA TANGAN PENJAMIN / APPROVAL</p>
                    <div class="signature-line"></div>
                </td>
                <td width="20%"></td>
                <td width="40%">
                    <p>TANDA TANGAN GUEST / SIGNATURE</p>
                    <div class="signature-line"></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-footer">
        <span class="invoice-id">{{ $transaction['transaction_id'] }}</span>
    </div>
</div>

<style>
    @page {
        size: landscape;
        margin: 5mm;
    }

    body {
        margin: 0;
        padding: 0;
        font-size: 9pt;
        font-family: Arial, sans-serif;
    }

    .container-landscape {
        width: 90%;
        max-width: 297mm; /* A4 landscape width */
        height: 210mm; /* A4 landscape height */
        margin: 0 auto;
        padding: 5mm;
        box-sizing: border-box;
    }

    .header-row {
        display: flex;
        align-items: center;
        margin-bottom: 3mm;
    }

    .logo-container {
        width: 15mm;
        margin-right: 3mm;
    }

    .logo {
        max-width: 100%;
        height: auto;
    }

    .hotel-info {
        text-align: center;
        flex-grow: 1;
    }

    .hotel-info h2 {
        margin: 0 0 2mm;
        font-size: 12pt;
    }

    .hotel-info p {
        margin: 0;
        font-size: 8pt;
    }

    .customer-details {
        margin-bottom: 3mm;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8pt;
    }

    .info-table td {
        padding: 1mm 1mm;
        border: 0.5pt solid #000;
    }

    .form-container {
        margin-bottom: 3mm;
    }

    .receipt-table {
        width: 100%;
        border-collapse: collapse;
        border: 0.5pt solid #000;
    }

    .receipt-table td {
        border: 0.5pt solid #000;
        padding: 1mm 1mm;
        font-size: 8pt;
    }

    .inner-table {
        width: 100%;
        border-collapse: collapse;
        border: 0.5pt solid #000;
    }

    .inner-table th, .inner-table td {
        padding: 1mm;
        font-size: 8pt;
        border: 0.5pt solid #000;
        border-bottom: 0.5pt solid #ddd;
    }

    .section-header {
        font-weight: bold;
        background-color: #f2f2f2;
        text-align: center;
        font-size: 9pt;
    }

    .jumlah-amount-header {
        font-weight: bold;
        background-color: #f2f2f2;
        text-align: center;
        font-size: 11pt;
        color: #000;
    }

    .total-amount {
        font-weight: bold;
        font-size: 10pt;
    }

    .mini-row {
        height: 3mm;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .signatures {
        margin-top: 3mm;
    }

    .sign-table {
        width: 100%;
        border-collapse: collapse;
    }

    .sign-table td {
        vertical-align: bottom;
        padding: 1mm;
        font-size: 7pt;
    }

    .signature-line {
        border-top: 0.5pt solid #000;
        margin-top: 5mm;
    }

    .invoice-footer {
        margin-top: 2mm;
        text-align: right;
    }

    .invoice-id {
        font-size: 9pt;
        color: blue;
    }

    @media print {
        .container-landscape {
            width: 100%;
            max-width: none;
            height: auto;
        }
    }
</style>
