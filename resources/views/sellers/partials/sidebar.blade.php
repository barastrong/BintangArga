<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<style>
/* Sidebar Cards Base Styles */
.sidebar-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: none;
}

/* Card Headers */
.sidebar-card .card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 16px;
}

.sidebar-card .card-header h5 {
    font-weight: 600;
    margin: 0;
    color: #333;
    font-size: 16px;
}

.header-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ff8000;
    font-size: 18px;
}

/* Profile Card */
.profile-card .card-body {
    padding: 24px 16px;
}

.profile-image-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto;
}

.profile-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.profile-name {
    font-weight: 600;
    margin-bottom: 4px;
    color: #333;
}

.profile-email {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 16px;
}

.btn-edit-profile {
    background-color: rgba(255, 128, 0, 0.1);
    color: #ff8000;
    border: none;
    border-radius: 20px;
    padding: 6px 16px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-edit-profile:hover {
    background-color: rgba(255, 128, 0, 0.2);
    color: #ff8000;
}

/* Menu Card */
.menu-list {
    padding: 8px;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    text-decoration: none;
    color: #495057;
    border-radius: 8px;
    margin-bottom: 4px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.menu-item:hover {
    background-color: rgba(255, 128, 0, 0.05);
    color: #ff8000;
}

.menu-item.active {
    background-color: rgba(255, 128, 0, 0.1);
    color: #ff8000;
    font-weight: 600;
}

.menu-icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 16px;
    color: inherit;
}

.menu-item.active .menu-icon {
    color: #ff8000;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .profile-image-wrapper {
        width: 80px;
        height: 80px;
    }
    
    .profile-image {
        width: 80px;
        height: 80px;
    }
}
</style>
<div class="sidebar-card profile-card mb-4">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="header-icon me-2">
                <i class="fas fa-user-circle"></i>
            </div>
            <h5 class="mb-0">Info Penjual</h5>
        </div>
    </div>
    <div class="card-body text-center">
        <div class="profile-image-wrapper mb-3">
            @if(Auth::user()->seller->foto_profil)
                <img src="{{ asset('storage/' . Auth::user()->seller->foto_profil) }}" alt="Profil Penjual" class="profile-image">
            @else
                <img src="{{ asset('images/default-user.png') }}" alt="Default Profil" class="profile-image">
            @endif
        </div>
        <h5 class="profile-name">{{ Auth::user()->seller->nama_penjual }}</h5>
        <p class="profile-email">{{ Auth::user()->seller->email_penjual }}</p>
        <a href="{{ route('seller.edit') }}" class="btn-edit-profile">
            <i class="fas fa-pen me-1"></i> Edit Profil
        </a>
    </div>
</div>

<div class="sidebar-card menu-card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="header-icon me-2">
                <i class="fas fa-bars"></i>
            </div>
            <h5 class="mb-0">Menu Penjual</h5>
        </div>
    </div>
    <div class="menu-list">
        <a href="{{ route('products.index') }}" class="menu-item">
            <div class="menu-icon">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <span>Home</span>
        </a>
        <a href="{{ route('seller.dashboard') }}" class="menu-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('seller.products') }}" class="menu-item {{ request()->routeIs('seller.products') || request()->routeIs('seller.products.*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fas fa-box"></i>
            </div>
            <span>Produk Saya</span>
        </a>
        <a href="{{ route('seller.orders') }}" class="menu-item {{ request()->routeIs('seller.orders') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('seller.edit') }}" class="menu-item {{ request()->routeIs('seller.edit') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <span>Edit Profil</span>
        </a>
    </div>
</div>
</body>
</html> 