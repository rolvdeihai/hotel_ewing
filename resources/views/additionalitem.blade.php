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
        {{-- <div class="mb-4">
            <form action="/search" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by item name" aria-label="Search by item name" aria-describedby="basic-addon2">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                </div>
            </form>
        </div> --}}

        <!-- Add Item Form -->
        <form action="/add_xitem" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="booking_id" value="{{$bookings->id}}">

            <div class="mb-3">
                <label for="pricelist_id" class="form-label">Additional Item (Transaksi Jual/Beli):</label>
                <select class="form-control" id="pricelist_id" name="pricelist_id" onchange="toggleInputs('pricelist_id', 'item_id')">
                    <option value="">Additional Item (Jual)</option>
                    @foreach($price_lists as $price_list)
                        <option value="{{ $price_list->id }}">{{ $price_list->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="item_id" class="form-label">Additional Item (Operasional)</label>
                <select class="form-control" id="item_id" name="item_id" onchange="toggleInputs('item_id', 'pricelist_id')">
                    <option value="">Additional Item (Kebutuhan)</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Item
            </button>
        </form>

        <script>
            function toggleInputs(activeId, disableId) {
                let activeSelect = document.getElementById(activeId);
                let disableSelect = document.getElementById(disableId);

                if (activeSelect.value) {
                    disableSelect.disabled = true;
                } else {
                    disableSelect.disabled = false;
                }
            }
        </script>
    </section>
@endsection
