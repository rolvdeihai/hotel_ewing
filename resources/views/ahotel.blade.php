@extends('layout.Nav')

@section('content')
<!-- home.blade.php -->
<section class="dashboard">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="brand-name mb-5" style ="text-left">JayJo Management System</h1>
            </div>
        </div>
        <div>
        <h1 class="text-center mb-2" style="font-size: 2rem;">Hotel Dwipa</h1>
                <p class="text-center mb-5" style="font-size: 1rem;">
                    Gg. Arwana 1 No.2B, Sukaraja, Kec. Bumi Waras, Kota Bandar Lampung, Lampung 35226
                </p>
        </div>
        <h3 class="text-center mb-4">Welcome, John Doe!</h3>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Current Date & Time</h5>
                        <p class="digital-clock" id="digital-clock">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Available Rooms</h5>
                        <p class="digital-info" id="available-rooms">25</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="digital-info" id="total-revenue">Rp 1,500,000,000</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="mt-4">Recent Check-Out</h4>
                <ul class="list-group">
                    <li class="list-group-item">Room 102 checked out on 2025-02-17 at 11:00</li>
                    <li class="list-group-item">Room 103 checked out on 2025-02-16 at 10:30</li>
                    <li class="list-group-item">Room 101 checked out on 2025-02-15 at 12:00</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="mt-4">Recent Check-In</h4>
                <ul class="list-group">
                    <li class="list-group-item">Room 104 checked in on 2025-02-18 at 15:00</li>
                    <li class="list-group-item">Room 105 checked in on 2025-02-17 at 14:00</li>
                    <li class="list-group-item">Room 106 checked in on 2025-02-16 at 16:00</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
    .dashboard {
        padding: 20px;
    }
    .card {
        border: 3px solid #007bff;
        border-radius: 10px;
    }
    .card-title {
        font-size: 1.5rem;
        color: #007bff;
    }
    .digital-clock, .digital-info {
        font-size: 1rem;
        font-family: 'Courier New', Courier, monospace;
        background-color: #007bff;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        color: white;
        letter-spacing: 1px;
        font-weight : bold;
        transition : transform 0.3s;
    }
    #digital-clock:hover, .digital-info:hover {
        transform: scale(1.1);
    }
    .list-group-item {
        font-size: 1.1rem;
        border: 1px solid black;

    }
    .brand-name {
    font-size: 1rem; /* Adjust size as needed */
    display: block; /* Make it a block element */
    font-weight: bold; /* Make it bold */
    color: orange; /* Set text color to orange */
    text-transform: uppercase; /* Optional: make text uppercase */
    letter-spacing: 1px; /* Optional: add spacing between letters */
    }

</style>

<script>
    function updateClock() {
        const now = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('digital-clock').innerText = now.toLocaleString('en-US', options);
    }

    setInterval(updateClock, 1000);
    updateClock(); // Initial call to display clock immediately
</script>
@endsection
