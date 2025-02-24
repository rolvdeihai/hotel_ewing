@extends('layout.Nav')

@section('content')
    <section class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Cash Transactions (Saldo {{ $saldo->saldo }})</h2>
            <a href="/addtransaction" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Transaction
            </a>
        </div>

        <!-- Filter Form -->
        <form id="combinedForm" class="d-flex mb-5" action="/viewSlide" method="get">
            @csrf
            <div class="row g-2">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search by Item name:</label>
                    <input class="form-control me-2" type="search" placeholder="Search by Description" aria-label="Search" id="search" name="search">
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

        <!-- Sort Button -->
        <button id="sortButton" class="btn btn-secondary mb-3">Sort Order</button>

        <div class="table-responsive">
            <table id="transactionsTable" class="table table-bordered border-dark">
                <thead>
                    <tr class="table-light">
                        <th class="border border-dark text-center align-middle">Description</th>
                        <th class="border border-dark text-center align-middle">QTY</th>
                        <th class="border border-dark text-center align-middle">Transaction</th>
                        <th class="border border-dark text-center align-middle">Saldo</th>
                        <th class="border border-dark text-center align-middle">Date</th>
                        <th class="border border-dark text-center align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cashTransactions as $transaction)
                        <tr>
                            <td class="border border-dark text-center align-middle">{{ $transaction->description }}</td>
                            <td class="border border-dark text-center align-middle">{{ $transaction->qty }}</td>
                            <td class="border border-dark align-middle">{{ $transaction->transaction }}</td>
                            <td class="border border-dark text-end align-middle">{{ number_format($transaction->saldo) }}</td>
                            <td class="border border-dark text-center align-middle">
                                {{ $transaction->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="border border-dark text-center align-middle">
                                <form action="/delete_kas" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this transaction?')" style="margin-bottom: 5px" type="submit">Delete</button>
                                </form>
                                <form action="/cancel_kas" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to cancel this transaction?')">
                                        <i class="bi bi-trash"></i> Cancel
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center border border-dark">No transactions found.</td>
                        </tr>
                    @endforelse
                    <h1>{{ number_format($grandTotal) }}</h1>
                </tbody>

                @if ($grandTotal !== null)
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="2" class="border border-dark text-end align-middle"><strong>Grand Total:</strong></td>
                        <td class="border border-dark text-end align-middle"><strong>{{ number_format($grandTotal) }}</strong></td>
                        <td colspan="9" class="border border-dark"></td>
                    </tr>
                </tfoot>
            @endif
                
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $cashTransactions->appends(request()->query())->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let table = document.getElementById('transactionsTable').getElementsByTagName('tbody')[0];
            let rows = Array.from(table.rows);
            let sortButton = document.getElementById('sortButton');
            let isAscending = false; // Default: Newest to Oldest (Descending by Date)

            function sortTable() {
                rows.sort((a, b) => {
                    let dateA = new Date(a.cells[4].textContent.trim());
                    let dateB = new Date(b.cells[4].textContent.trim());

                    if (dateA.getTime() === dateB.getTime()) {
                        let saldoA = parseFloat(a.cells[3].textContent.replace(/,/g, ''));
                        let saldoB = parseFloat(b.cells[3].textContent.replace(/,/g, ''));

                        return isAscending ? saldoB - saldoA : saldoA - saldoB;
                    }

                    return isAscending ? dateA - dateB : dateB - dateA;
                });

                rows.forEach(row => table.appendChild(row));

                isAscending = !isAscending;
                sortButton.textContent = isAscending ? "Sort Oldest to Newest" : "Sort Newest to Oldest";
            }

            sortTable();

            sortButton.addEventListener('click', sortTable);
        });
    </script>
@endsection