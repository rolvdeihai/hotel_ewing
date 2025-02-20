

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

     <!-- New Horizontal Navbar at the Top -->
     <nav class="navbar navbar-expand-lg navbar-dark navbar-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hotel Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

         </div>
            <div class="navbar-top-content" id="navbarTop">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signin">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account-maintenance">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="navbar-hor">
            <ul class="navbar-nav flex-column">
                <li class="nav-item-home">
                    <h5 class="nav-link"><a href="/">HOME</a></h5>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/rooms">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/price_list">Price List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewItems">Logistics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/transactions">Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewKas">Kas</a>
                </li>
            </ul>
        </div>
    </nav>

<!-- Main Content -->
<div class="container mt-4" style="margin-left: 270px;">
    <!-- Content will be loaded from separate files -->
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="container">
    @yield('content')
</div>


</body>
</html>
