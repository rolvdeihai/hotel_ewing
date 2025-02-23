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
            <h2>Edit Item</h2>
            <a href="/logistics" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>

        @php
        // Assuming $item contains the data of the item to be edited.
        // This should be fetched from the database based on the item ID.
        // Example: $item = \App\Models\Item::find($itemId);

        // Placeholder data for demonstration if $item is not available
        if (!isset($item)) {
            $item = (object) [
                'id' => 1,
                'name' => 'Example Item',
                'description' => 'This is an example item description.',
                'price' => 1000,
                'stocks' => 10,
                'auto_stock' => 'none',
                'auto_stock_value' => 0,
                'updated_at' => '2025-02-15 10:00:00'
            ];
        }
        @endphp

        <form action="/updatelogistics" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $item->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $item->price }}" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="stocks" class="form-label">Stocks</label>
                <input type="number" class="form-control" id="stocks" name="stocks" value="{{ $item->stocks }}" required>
            </div>
            <div class="mb-3">
                <label for="auto_stock" class="form-label">Auto Stock</label>
                <select class="form-select" id="auto_stock" name="auto_stock">
                    <option value="none" {{ $item->auto_stock == 'none' ? 'selected' : '' }}>None</option>
                    <option value="checkIn" {{ $item->auto_stock == 'checkIn' ? 'selected' : '' }}>Check In</option>
                    <option value="checkOut" {{ $item->auto_stock == 'checkOut' ? 'selected' : '' }}>Check Out</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="auto_stock_value" class="form-label">Auto Stock Value</label>
                <input type="number" class="form-control" id="auto_stock_value" name="auto_stock_value" value="{{ $item->auto_stock_value }}" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-2"></i>Save Changes
            </button>
        </form>
    </section>
@endsection
