<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
/* Base Styles */
body {
    background-color: #f9fafb;
    color: #333;
    font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
}

.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Main Card */
.main-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

/* Header */
.card-header {
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
    position: relative;
    overflow: hidden;
}

.header-accent {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    width: 25%;
    background: linear-gradient(90deg, transparent, rgba(255, 128, 0, 0.08));
    z-index: 1;
}

.icon-circle {
    width: 48px;
    height: 48px;
    background-color: #ff8000;
    box-shadow: 0 4px 10px rgba(255, 128, 0, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Welcome Card */
.welcome-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
    border-left: 3px solid #ff8000;
    position: relative;
    overflow: hidden;
}

.welcome-accent {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    width: 25%;
    background: linear-gradient(90deg, transparent, rgba(255, 128, 0, 0.05));
    z-index: 1;
}

.welcome-icon-circle {
    background-color: #fff;
    padding: 16px;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-left: 3px solid #ff8000;
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.welcome-icon-circle i {
    color: #ff8000;
}

/* Stat Cards */
.stat-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
    border: none;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
}

.stat-accent {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    width: 40%;
    z-index: 1;
}

.blue-accent {
    background: linear-gradient(135deg, transparent, rgba(13, 110, 253, 0.08));
}

.orange-accent {
    background: linear-gradient(135deg, transparent, rgba(255, 128, 0, 0.08));
}

.green-accent {
    background: linear-gradient(135deg, transparent, rgba(25, 135, 84, 0.08));
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.blue {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.orange {
    background-color: rgba(255, 128, 0, 0.1);
    color: #ff8000;
}

.green {
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.orange-text {
    color: #ff8000;
}

.stat-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 14px;
}

.blue-link {
    color: #0d6efd;
}

.orange-link {
    color: #ff8000;
}

.green-link {
    color: #198754;
}

.stat-link:hover {
    opacity: 0.8;
}

/* Product List Card */
.product-list-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
    border: none;
}

.product-list-card .card-header {
    background: linear-gradient(to right, #fff, rgba(255, 128, 0, 0.05));
    border-bottom: 1px solid #f0f0f0;
}

.product-icon-circle {
    width: 32px;
    height: 32px;
    background-color: #ff8000;
    box-shadow: 0 3px 6px rgba(255, 128, 0, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-list-card thead {
    background-color: rgba(248, 249, 250, 0.6);
}

.product-item-icon {
    width: 36px;
    height: 36px;
    background-color: rgba(255, 128, 0, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ff8000;
}

.category-badge {
    background-color: rgba(255, 128, 0, 0.1);
    color: #ff8000;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.stock-badge {
    background-color: #f8f9fa;
    color: #212529;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid #e9ecef;
    display: inline-block;
}

.price-text {
    color: #333;
}

.btn-view-all {
    background-color: #0d6efd;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-block;
    font-weight: 500;
}

.btn-view-all:hover {
    background-color: #0b5ed7;
    color: white;
}

/* Empty State */
.empty-state {
    padding: 32px;
}

.empty-icon-container {
    width: 80px;
    height: 80px;
    position: relative;
}

.empty-icon-pulse {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 128, 0, 0.1) 0%, rgba(255, 128, 0, 0.05) 100%);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.empty-icon-center {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ff8000;
}

.btn-add-product {
    background-color: #ff8000;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-block;
    font-weight: 500;
}

.btn-add-product:hover {
    background-color: #e67300;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(255, 128, 0, 0.3);
}

/* Animation */
@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(255, 128, 0, 0.2);
    }
    
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(255, 128, 0, 0);
    }
    
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(255, 128, 0, 0);
    }
}
</style>
<body>
<div class="dashboard-container py-4">
    <div class="row g-4">
        <div class="col-md-3">
            @include('sellers.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="main-card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-header p-4 position-relative">
                    <div class="header-accent"></div>
                    <div class="d-flex align-items-center position-relative">
                        <div class="icon-circle me-3">
                            <i class="fas fa-tachometer-alt text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Dashboard Penjual</h5>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                        </div>
                    @endif

                    <div class="welcome-card p-4 rounded-lg mb-4 position-relative">
                        <div class="welcome-accent"></div>
                        <div class="row align-items-center position-relative">
                            <div class="col-auto d-none d-md-block">
                                <div class="welcome-icon-circle">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h3 class="mb-1 fw-bold">Selamat Datang, {{ $seller->nama_penjual }}!</h3>
                                <p class="text-muted mb-0">Ini adalah dashboard penjual Anda. Di sini Anda dapat mengelola produk, melihat pesanan, dan mengupdate profil Anda.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="stat-card products-card h-100">
                                <div class="card-body p-4 position-relative">
                                    <div class="stat-accent blue-accent"></div>
                                    <div class="position-relative">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-muted text-uppercase mb-0 small fw-bold">Total Produk</h6>
                                            <div class="stat-icon blue">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        </div>
                                        <h3 class="mb-0 fw-bold">{{ App\Models\Product::where('seller_id', $seller->id)->count() }}</h3>
                                        <div class="mt-3 pt-2 border-top">
                                            <a href="{{ route('seller.products') }}" class="stat-link blue-link">
                                                <span class="me-auto">Lihat Semua</span>
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="stat-card orders-card h-100">
                                <div class="card-body p-4 position-relative">
                                    <div class="stat-accent orange-accent"></div>
                                    <div class="position-relative">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-muted text-uppercase mb-0 small fw-bold">Pesanan Baru</h6>
                                            <div class="stat-icon orange">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <h3 class="mb-0 fw-bold orange-text">0</h3>
                                        <div class="mt-3 pt-2 border-top">
                                            <a href="{{ route('seller.orders') }}" class="stat-link orange-link">
                                                <span class="me-auto">Lihat Semua</span>
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="stat-card stock-card h-100">
                                <div class="card-body p-4 position-relative">
                                    <div class="stat-accent green-accent"></div>
                                    <div class="position-relative">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-muted text-uppercase mb-0 small fw-bold">Total Stock</h6>
                                            <div class="stat-icon green">
                                                <i class="fas fa-cubes"></i>
                                            </div>
                                        </div>
                                        <h3 class="mb-0 fw-bold">
                                            {{ App\Models\Product::where('seller_id', $seller->id)->get()->sum('total_stock') }}
                                        </h3>
                                        <div class="mt-3 pt-2 border-top">
                                            <a href="{{ route('seller.products') }}" class="stat-link green-link">
                                                <span class="me-auto">Kelola Stock</span>
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="product-list-card mt-4 overflow-hidden">
                        <div class="card-header p-3">
                            <div class="d-flex align-items-center">
                                <div class="product-icon-circle me-3">
                                    <i class="fas fa-fire text-white small"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Produk Terbaru</h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $latestProducts = App\Models\Product::where('seller_id', $seller->id)
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp
                            
                            @if($latestProducts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3">Nama Barang</th>
                                                <th class="px-4 py-3">Kategori</th>
                                                <th class="px-4 py-3">Stock</th>
                                                <th class="px-4 py-3">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($latestProducts as $product)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="product-item-icon me-3">
                                                            <i class="fas fa-box-open small"></i>
                                                        </div>
                                                        <span class="fw-medium">{{ $product->nama_barang }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="category-badge">{{ $product->category->nama ?? 'Tanpa Kategori' }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="stock-badge">{{ $product->total_stock }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($product->min_price == $product->max_price)
                                                        <span class="fw-bold price-text">Rp {{ number_format($product->min_price, 0, ',', '.') }}</span>
                                                    @else
                                                        <span class="fw-bold price-text">Rp {{ number_format($product->min_price, 0, ',', '.') }} - 
                                                        Rp {{ number_format($product->max_price, 0, ',', '.') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 bg-light border-top">
                                    <a href="{{ route('seller.products') }}" class="btn-view-all">
                                        <i class="fas fa-list me-1"></i> Lihat Semua Produk
                                    </a>
                                </div>
                            @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-icon-container mx-auto mb-4 position-relative">
                                        <div class="empty-icon-pulse"></div>
                                        <div class="empty-icon-center">
                                            <i class="fas fa-box-open fa-2x"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-2">Belum Ada Produk</h5>
                                    <p class="text-muted mb-4">Anda belum memiliki produk yang ditambahkan</p>
                                    <a href="{{ route('products.create') }}" class="btn-add-product">
                                        <i class="fas fa-plus me-2"></i> Tambah Produk
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>