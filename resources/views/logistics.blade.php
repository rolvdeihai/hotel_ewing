@extends('layout.Nav')

@section('content')
<script>
 document.getElementById('sortButton').addEventListener('click', function () {
            let table = document.getElementByClass('table').getElementsByTagName('tbody')[0];
            let rows = Array.from(table.rows);
            let isAscending = this.getAttribute('data-sort') === 'asc';

            rows.sort((a, b) => {
                let dateA = new Date(a.cells[4].textContent.trim()); // Extract date from cell
                let dateB = new Date(b.cells[4].textContent.trim());

                return isAscending ? dateB - dateA : dateA - dateB; // Toggle sorting
            });

            rows.forEach(row => table.appendChild(row));

            // Toggle sorting order
            this.setAttribute('data-sort', isAscending ? 'desc' : 'asc');
            this.textContent = isAscending ? "Sort Newest to Oldest" : "Sort Oldest to Newest";
        });
</script>    
    <section class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Logistics Management</h2>
            <div>
                <button class="btn btn-success me-2">
                    <i class="bi bi-plus-circle me-2"><a href="/additem" style="color: white; font-style: normal;">Add Item</a>
                    </i>

                </button>
                <button class="btn btn-danger">
                    <i class="bi bi-arrow-clockwise me-2"></i>Delete Item
                </button>
                
            </div>
        </div>

        <form id="combinedForm" class="d-flex mb-5" action="/viewSlideLogistics" method="get">
            @csrf
            <div class="row g-2">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search by Item name:</label>
                    <input class="form-control me-2" type="search" placeholder="Search by Guest Name" aria-label="Search" id="search" name="search">
                </div>
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" name="start_date" class="form-control" value="">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input type="date" name="end_date" class="form-control" value="">
                </div>
                <div class="col-md-4 d-flex align-items-end mt-3">
                    <button type="submit" class="btn btn-primary">Search & Filter</button>
                </div>
            </div>
        </form>

        {{-- <div class="d-flex justify-content-between align-items-center mb-4">
            <form id="searchForm" class="d-flex" action="/viewSlideLogistics" method="get" >
                @csrf
                <input class="form-control me-2" type="search" placeholder="Search by Item Name" aria-label="Search" id="search" name="search" >
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>

        <div>
            <form method="GET" action="/viewSlideLogistics" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            </div> --}}

        <div class="table-responsive">
            <table class="table table-bordered border-dark">
                <thead>
                    <tr class="table-light">
                        <th class="border border-dark text-center align-middle">ID</th>
                        <th class="border border-dark text-center align-middle">Name</th>
                        <th class="border border-dark text-center align-middle">Description</th>
                        <th class="border border-dark text-center align-middle">Price</th>
                        <th class="border border-dark text-center align-middle">Stocks</th>
                        <th class="border border-dark text-center align-middle">Auto Stock</th>
                        <th class="border border-dark text-center align-middle">Auto Stock Value</th>
                        <th class="border border-dark text-center align-middle">Last Updated</th>
                        <th class="border border-dark text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items ?? [] as $item)
                        <tr>
                            <td class="border border-dark text-center align-middle">{{ $item->id }}</td>
                            <td class="border border-dark align-middle">{{ $item->name }}</td>
                            <td class="border border-dark align-middle">{{ $item->description }}</td>
                            <td class="border border-dark text-end align-middle">{{ number_format($item->price) }}</td>
                            <td class="border border-dark text-center align-middle">{{ $item->stocks }}</td>
                            <td class="border border-dark text-center align-middle">
                                @switch($item->auto_stock)
                                    @case('checkIn')
                                        <span class="badge bg-success">checkIn</span>
                                        @break
                                    @case('checkOut')
                                        <span class="badge bg-danger">checkOut</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">none</span>
                                @endswitch
                            </td>
                            <td class="border border-dark text-center align-middle">{{ $item->auto_stock_value }}</td>
                            <td class="border border-dark text-center align-middle">{{ $item->updated_at }}</td>
                            <td class="border border-dark text-center align-middle">
                                <form action="/editlogistics" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button class="btn btn-secondary btn-sm me-1" style="margin-bottom: 5px" type="submit">Edit</button>
                                </form>
                                <form action="/delete_logistic" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button class="btn btn-sm btn-danger" style="margin-bottom: 5px" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center border border-dark">No items found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $items->appends(request()->query())->links() }}
        </div>
    </section>
@endsection
