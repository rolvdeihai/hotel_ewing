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
            margin: 0;
            font-family: Arial, sans-serif;
            padding-top: 50px; /* Add padding to account for fixed top navbar */
        }

        /* Top Navbar */
        .navbar-top {
            background-color: #343a40;
            position: fixed;
            z-index: 1030;
            top: 0;
            width: 100%;
            height: 50px;
        }

        /* Side Navbar - Desktop */
        .side-navbar {
            background-color: #343a40;
            position: fixed;
            z-index: 1020;
            width: 12%;
            top: 50px;
            height: calc(100% - 50px);
            padding-top: 15px;
            transition: all 0.3s ease;
        }

        .side-navbar .navbar-nav {
            display: flex;
            flex-direction: column;
            padding: 0;
            width: 100%;
        }

        .side-navbar .nav-item {
            margin-bottom: 5%;
            margin-top: 5%;
            width: 100%;
        }

        .side-navbar .nav-link {
            display: block;
            width: 100%;
            padding: 8px 15px;
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .side-navbar .nav-link:hover {
            color: #adb5bd;
        }

        /* Main Container */
        .main-container {
            margin-left: 12%;
            padding: 20px;
            transition: margin 0.3s ease;
        }

        /* Card and other UI elements */
        .card {
            margin-bottom: 20px;
        }

        .title-box {
            background-color: #495057;
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
        }

        /* Responsive styles */
        @media (max-width: 1000px) {
            body {
                padding-top: 0; /* Remove padding as navbar is no longer fixed on mobile */
            }

            .navbar-top {
                position: relative;
                height: auto;
            }

            .side-navbar {
                width: 100%;
                position: relative;
                top: 0;
                height: auto;
                display: none; /* Hide by default on mobile */
            }

            .side-navbar.show {
                display: block; /* Show when toggled */
            }

            .main-container {
                margin-left: 0;
                padding: 15px;
            }

            /* Mobile-friendly table styles */
            .table-responsive {
                overflow-x: auto;
            }

            .table {
                width: 100%;
                white-space: nowrap;
            }

            .table th, .table td {
                padding: 5px;
                font-size: 0.8rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
            .navbar-top .nav-link {
        margin: 10px 0; /* Add more margin */
        padding: 10px 15px; /* Ensure padding is the same as side navbar items */
        display: block; /* Make sure each link takes up the full width */
        width: 100%; /* Ensure full width */
        text-align: left; /* Center text */
    }

    .navbar-top .nav-item {
        width: 100%; /* Ensure each item takes up the full width */
    }

    /* Ensure the form for logout also has the same styling */
    .navbar-top form {
        margin: 10px 0; /* Add more margin */
        padding: 0; /* Remove padding from form */
        width: 100%; /* Ensure full width */
    }

    .navbar-top form .nav-link {
        display: block; /* Make sure the link takes up the full width */
        width: 100%; /* Ensure full width */
        text-align: left; /* Center text */
    }
    /* Adjust side navbar items */
    .side-navbar .nav-item {
        margin-bottom: 2%; /* Reduce margin between side navbar items */
        margin-top: 2%; /* Reduce margin between side navbar items */
    }

    .side-navbar .nav-link {
        padding: 10px 15px; /* Adjust padding for side navbar items */
        font-size: 1rem; /* Ensure font size is consistent */
    }
        }

     
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-hotel brand-logo"></i>
                Hotel Management System
            </a>
            <button class="navbar-toggler" type="button" id="topNavToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarTop">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile"><i class="fas fa-user mr-1"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        @guest
                            <a class="nav-link" href="/signin"><i class="fas fa-sign-in-alt mr-1"></i> Masuk</a>
                        @else
                            <form action="/logout" method="POST">
                                @csrf
                                <a class="nav-link" type="submit" onclick="return confirm('Apakah anda yakin untuk log out?')">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                                </a>
                            </form>
                        @endguest
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account-maintenance"><i class="fas fa-user-cog mr-1"></i> Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Side Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark side-navbar" id="sideNavbar">
        <div class="container-fluid p-0">
            <ul class="navbar-nav flex-column w-100">
                <li class="nav-item">
                    <a class="nav-link" href="/rooms"><i class="fas fa-bed mr-2"></i>Kamar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/price_list"><i class="fas fa-tags mr-2"></i>List Harga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewItems"><i class="fas fa-boxes mr-2"></i>Logistik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/transactions"><i class="fas fa-exchange-alt mr-2"></i>Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewKas"><i class="fas fa-money-bill-wave mr-2"></i>Kas</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container" id="mainContainer">
        <!-- Content will be loaded here -->
        @yield('content')
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const topNavToggle = document.getElementById('topNavToggle');
        const navbarTop = document.getElementById('navbarTop');
        const sideNavbar = document.getElementById('sideNavbar');
        const mainContainer = document.getElementById('mainContainer');
        
        // Function to check if we're on mobile view
        function isMobileView() {
            return window.innerWidth <= 1000;
        }
        
        // Function to adjust layout based on viewport size
        function adjustLayout() {
            if (isMobileView()) {
                // Mobile view layout adjustments
                mainContainer.style.marginLeft = '0';
                // Only hide the side navbar if it's not toggled to show
                if (!sideNavbar.classList.contains('show')) {
                    sideNavbar.style.display = 'none';
                }
                // Add body padding only for desktop
                document.body.style.paddingTop = '0';
            } else {
                // Desktop view layout adjustments
                mainContainer.style.marginLeft = '12%';
                sideNavbar.style.display = 'block';
                document.body.style.paddingTop = '50px';
            }
        }
        
        // Toggle navigation on mobile
        topNavToggle.addEventListener('click', function() {
            navbarTop.classList.toggle('show');
            
            // In mobile view, also toggle the side navbar
            if (isMobileView()) {
                sideNavbar.classList.toggle('show');
                sideNavbar.style.display = sideNavbar.classList.contains('show') ? 'block' : 'none';
            }
        });
        
        // Adjust layout when window is resized
        window.addEventListener('resize', adjustLayout);
        
        // Initialize layout based on current viewport
        adjustLayout();
        
        // Additional listener for orientation changes (important for mobile devices)
        window.addEventListener('orientationchange', adjustLayout);
    });
    </script>
</body>
</html>