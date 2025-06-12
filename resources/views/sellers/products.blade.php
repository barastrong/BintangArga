<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<style>
    /* Modern Color Scheme */
    :root {
        --primary: #FF7A00;
        --primary-light: #FFF0E6;
        --primary-dark: #E66D00;
        --secondary: #4A5568;
        --light-gray: #F7FAFC;
        --border-color: #EDF2F7;
        --success: #48BB78;
        --warning: #F59E0B;
        --danger: #F56565;
        --info: #4299E1;
    }

    /* Base Styles */
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid var(--border-color);
        padding: 18px 24px;
    }

    .card-header h5 {
        font-weight: 600;
        margin: 0;
        font-size: 18px;
        color: var(--secondary);
    }

    .card-body {
        padding: 24px;
    }

    /* Button Styles */
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        border-radius: 6px;
        font-weight: 500;
        padding: 8px 16px;
        box-shadow: 0 2px 4px rgba(255, 122, 0, 0.15);
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        box-shadow: 0 4px 8px rgba(255, 122, 0, 0.2);
        transform: translateY(-1px);
    }

    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
        width: 36px;
        padding: 0;
        border-radius: 8px;
    }

    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary);
        color: white;
    }

    .btn-outline-info {
        color: var(--info);
        border-color: var(--info);
    }

    .btn-outline-info:hover {
        background-color: var(--info);
        color: white;
    }

    .btn-outline-danger {
        color: var(--danger);
        border-color: var(--danger);
    }

    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        border-top: none;
        border-bottom: 2px solid var(--border-color);
        padding: 12px 16px;
        background-color: var(--light-gray);
    }

    .table td {
        vertical-align: middle;
        padding: 16px;
        border-top: 1px solid var(--border-color);
    }

    .table tr:hover {
        background-color: var(--primary-light);
    }

    /* Product Image */
    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 2px solid white;
    }

    /* Status Badges */
    .badge {
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 12px;
    }

    .badge-stock {
        background-color: var(--primary-light);
        color: var(--primary);
    }

    /* Price Tag */
    .price-tag {
        font-weight: 600;
        color: var(--primary);
        background-color: var(--primary-light);
        padding: 5px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    /* Action Buttons Group */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-buttons form {
        margin: 0;
    }

    /* Empty State */
    .empty-state {
    background-color: white;
    border-radius: 10px;
    padding: 50px 40px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .empty-state-img {
        max-width: 120px;
        height: auto;
        display: block;
        margin: 0 auto 30px;
    }

    .empty-state h4 {
        color: var(--secondary);
        margin-bottom: 16px;
        font-weight: 600;
    }

    .empty-state p {
        color: #718096;
        margin-bottom: 28px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-state .btn {
        padding: 10px 20px;
        font-weight: 500;
    }

    /* Alert Styling */
    .alert {
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        border: none;
    }

    .alert-success {
        background-color: rgba(72, 187, 120, 0.1);
        color: #2F855A;
        border-left: 4px solid var(--success);
    }

    /* Sidebar */
    .sidebar {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
    }

    .sidebar-title {
        font-weight: 600;
        color: var(--secondary);
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        margin: 0;
        transition: all 0.2s ease;
    }

    .sidebar-menu li a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: var(--secondary);
        text-decoration: none;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu li a:hover {
        background-color: var(--primary-light);
        color: var(--primary);
    }

    .sidebar-menu li.active a {
        background-color: var(--primary-light);
        color: var(--primary);
        border-left: 3px solid var(--primary);
        font-weight: 500;
    }

    .sidebar-menu li i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h5 {
        display: flex;
        align-items: center;
    }

    .page-header h5 i {
        margin-right: 10px;
        color: var(--primary);
    }

    /* Pagination */
    .pagination {
        margin-top: 20px;
    }

    .page-link {
        color: var(--secondary);
        border: 1px solid var(--border-color);
        margin: 0 3px;
        border-radius: 6px;
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
<body>
<div class="container py-4 ">
    <div class="row">
    <div class="col-md-3">
            @include('sellers.partials.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="page-header">
                        <h5><i class="fas fa-box-open"></i> Produk Saya</h5>
                        <a href="{{ route('products.create') }}" class="btn btn-primary text-white">
                            <i class="fas fa-plus mr-2"></i> Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Stock</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            @if($product->gambar)
                                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="product-img">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="product-img">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $product->nama_barang }}</div>
                                            <small class="text-muted">ID: #{{ $product->id }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">
                                                {{ $product->category->nama ?? 'Tanpa Kategori' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt text-muted mr-2"></i>
                                                {{ $product->lokasi }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-stock">
                                                <i class="fas fa-cubes mr-1"></i> {{ $product->total_stock }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->min_price == $product->max_price)
                                                <div class="price-tag">
                                                    Rp {{ number_format($product->min_price, 0, ',', '.') }}
                                                </div>
                                            @else
                                                <div class="price-tag">
                                                    Rp {{ number_format($product->min_price, 0, ',', '.') }} -
                                                    Rp {{ number_format($product->max_price, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary btn-icon" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-info btn-icon" data-toggle="tooltip" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-icon" data-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination if needed -->
                        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <img src="{{ asset('/empty-box.svg') }}" alt="No Products" class="empty-state-img">
                            <h4>Anda belum memiliki produk</h4>
                            <p>Mulai tambahkan produk untuk dijual di platform kami dan tingkatkan bisnis Anda</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg text-white">
                                <i class="fas fa-plus mr-2"></i> Tambah Produk Pertama Anda
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
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</html>