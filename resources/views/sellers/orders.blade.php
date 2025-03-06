@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>
    /* Custom Colors */
    .text-orange {
        color: #FF8C00 !important;
    }
    
    .bg-orange {
        background-color: #FF8C00 !important;
    }
    
    .bg-orange-soft {
        background-color: rgba(255, 140, 0, 0.15) !important;
    }
    
    .btn-outline-orange {
        color: #FF8C00;
        border-color: #FF8C00;
    }
    
    .btn-outline-orange:hover {
        background-color: #FF8C00;
        color: white;
    }
    
    .bg-success-soft {
        background-color: rgba(40, 167, 69, 0.15) !important;
    }
    
    .bg-warning-soft {
        background-color: rgba(255, 152, 0, 0.15) !important;
    }
    
    .bg-secondary-soft {
        background-color: rgba(108, 117, 125, 0.15) !important;
    }
    
    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.15) !important;
    }

    
    /* Avatar */
    .avatar-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    
    /* Table Styles */
    .table {
        border-collapse: separate;
        border-spacing: 0 8px;
        margin-top: -8px;
    }
    
    .table tbody tr {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s;
    }
    
    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .table tbody td {
        background-color: #fff;
        border: none;
        padding: 15px;
    }
    
    .table tbody td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    
    .table tbody td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    
    /* Card Styles */
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07) !important;
    }
    
    /* Custom Scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 5px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #FF8C00;
        border-radius: 10px;
    }
    .container {
        max-width: 1400px;
        margin: 0 auto;
    }
</style>
<body>
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            @include('sellers.partials.sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-3">
                <!-- Card Header with Orange Accent -->
                <div class="card-header bg-white d-flex align-items-center py-3 border-0 position-relative">
                    <div class="position-absolute top-0 start-0 h-100 bg-orange" style="width: 4px;"></div>
                    <div class="d-flex align-items-center">
                        <div class="circle p-3 me-3">
                            <i class="fas fa-shopping-bag text-orange"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Daftar Pesanan</h5>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm fade show mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-success-soft rounded-circle me-3">
                                    <i class="fas fa-check text-success"></i>
                                </div>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger border-0 shadow-sm fade show mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-danger-soft rounded-circle me-3">
                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                </div>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <!-- Info Panel with Search -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <div class="card border-0 bg-light rounded-3 h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="rounded-circle bg-white p-3 shadow-sm me-3">
                                        <i class="fas fa-list-alt text-orange"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Total Pesanan</p>
                                        <h5 class="mb-0 fw-bold">{{ $orders->count() }} Pesanan</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm rounded-3 h-100">
                                <div class="card-body p-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-0">
                                            <i class="fas fa-search text-orange"></i>
                                        </span>
                                        <input type="text" class="form-control border-0 py-2" id="orderSearch" placeholder="Cari pesanan...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    @if ($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border-0" id="ordersTable">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="py-3 text-uppercase small fw-bold text-muted">ID</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Pembeli</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Produk</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Ukuran</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Jumlah</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Total</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Tanggal</th>
                                        <th class="py-3 text-uppercase small fw-bold text-muted">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">#{{ $order->id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-orange-soft text-orange me-2">
                                                        {{ substr($order->user->name, 0, 1) }}
                                                    </div>
                                                    <span class="fw-medium text-truncate">{{ $order->user->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $order->product->nama_barang }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light border rounded-pill px-3">{{ $order->size->size ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $order->quantity }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                            </td>
                                            <td>
                                                @if($order->status == 'completed')
                                                    <div class="badge bg-success-soft text-success rounded-pill px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                                    </div>
                                                @elseif($order->status == 'process')
                                                    <div class="badge bg-warning-soft text-warning rounded-pill px-3 py-2">
                                                        <i class="fas fa-spinner me-1"></i> Diproses
                                                    </div>
                                                @elseif($order->status == 'pending')
                                                    <div class="badge bg-secondary-soft text-warning rounded-pill px-3 py-2">
                                                        <i class="fas fa-clock me-1"></i> Menunggu
                                                    </div>
                                                @else
                                                    <div class="badge bg-danger-soft text-danger rounded-pill px-3 py-2">
                                                        <i class="fa-solid fa-ban"></i> Canceled
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-medium">{{ $order->created_at->format('d M Y') }}</span>
                                                    <span class="small text-muted">{{ $order->created_at->format('H:i') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                            @if($order->status == 'canceled')
                                                <span class="badge bg-light text-success border rounded-pill px-3 py-2">
                                                    <i class="fa-solid fa-ban"></i> Canceled
                                                </span>
                                                @elseif($order->status != 'completed')
                                                    <div class="dropdown">
                                                        <ul class="dropdown-menu shadow-sm border-0 rounded-3" aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                                            <li>
                                                                <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="process">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-spinner me-2 text-warning"></i> Proses Pesanan
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li><hr class="dropdown-divider my-1"></li>
                                                            <li>
                                                                <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="completed">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-check-circle me-2 text-success"></i> Selesaikan
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="badge bg-light text-success border rounded-pill px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Empty State with Modern Design -->
                        <div class="text-center py-5 bg-light rounded-4">
                            <div class="mb-4">
                                <div class="bg-white rounded-circle shadow-sm d-inline-flex justify-content-center align-items-center p-4 mb-3" style="width: 90px; height: 90px;">
                                    <i class="fas fa-shopping-cart fa-2x text-orange"></i>
                                </div>
                            </div>
                            <h5 class="fw-bold mb-3">Belum Ada Pesanan</h5>
                            <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">Pesanan dari pelanggan akan muncul di sini. Pastikan produk Anda selalu tersedia dan menarik.</p>
                            <a href="#" class="btn btn-outline-orange px-4 py-2 rounded-pill">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Produk Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple search functionality
    const searchInput = document.getElementById('orderSearch');
    const table = document.getElementById('ordersTable');
    const rows = table.getElementsByTagName('tr');
    
    searchInput.addEventListener('keyup', function() {
        const term = searchInput.value.toLowerCase();
        
        for(let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const textContent = row.textContent.toLowerCase();
            
            if(textContent.includes(term)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>
</html>
@endsection