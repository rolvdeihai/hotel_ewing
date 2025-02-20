@extends('layout.Nav')

@section('content')
    <section class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add Additional Item</h2>
            <a href="/#" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <form action="/search" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by item name" aria-label="Search by item name" aria-describedby="basic-addon2">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Add Item Form -->
        <form action="/additemsell" method="POST">
            @csrf

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Item
            </button>
        </form>
    </section>
@endsection
