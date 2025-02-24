@extends('layout.Nav')

@section('content')
    <section class="container-fluid py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New Item</h2>
            <a href="/viewItems" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>

        <form action="/additem" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="stocks" class="form-label">Stocks</label>
                <input type="number" class="form-control" id="stocks" name="stocks" required>
            </div>
            <div class="mb-3">
                <label for="auto_stock" class="form-label">Auto Stock</label>
                <select class="form-select" id="auto_stock" name="auto_stock" required>
                    <option value="none" selected>None</option>
                    <option value="checkIn">Check In</option>
                    <option value="checkOut">Check Out</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="auto_stock_value" class="form-label">Auto Stock Value</label>
                <input type="number" class="form-control" id="auto_stock_value" name="auto_stock_value" required>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Item
            </button>
        </form>
    </section>
@endsection
