@extends('layout.Nav')

@section('content')
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

        @if(isset($items) && count($items) > 0)
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        @endif
    </section>
@endsection
