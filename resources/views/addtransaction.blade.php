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
            <h2>Add New Transaction</h2>
            <a href="/viewkas" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>

        <form action="/addTransaction" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="qty" class="form-label">QTY</label>
                <input type="number" class="form-control" id="qty" name="qty" step="1" required>
            </div>
            <div class="mb-3">
                <label for="transaction" class="form-label">Transaksi (Rp)</label>
                <input type="number" class="form-control" id="transaction" name="transaction" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Transaction
            </button>
        </form>
    </section>
@endsection
