<style>
    :root {
        --hd-orange: #F57C00;
        --hd-orange-brown: #E67E22;
        --hd-dark-red: #B03A2E;
        --hd-black: #000000;
        --hd-grey: #333333;
        --hd-text-muted: #6b7280;
    }

    .top-bar {
        background: var(--hd-orange);
        padding: 12px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .top-logo {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .top-logo img {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        border: 2px solid #ffffff;
    }

    .top-logo-text {
        font-weight: 800;
        font-size: 20px;
        color: #ffffff;
    }

    .top-icons {
        margin-left: auto;
        display: flex;
        gap: 32px;
        align-items: center;
    }

    .icon-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #ffffff;
        text-decoration: none;
        font-size: 11px;
        font-weight: 500;
        position: relative;
    }

    .icon-item i {
        font-size: 20px;
        margin-bottom: 4px;
    }

    .icon-item.active {
        border-bottom: 2px solid #ffffff;
        padding-bottom: 2px;
    }
</style>

<header class="top-bar">
    <div class="top-logo">
        <a href="/" style="display:flex; align-items:center; gap:8px; text-decoration:none;">
            <img src="{{ asset('images/homeDomeLogo.png') }}" alt="HomeDome logo">
            <span class="top-logo-text">HomeDome</span>
        </a>
    </div>

    <div class="top-icons">
        <a href="{{ route('admin.dashboard') }}" class="icon-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="icon-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Inventory</span>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="icon-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Orders</span>
        </a>

        <div class="icon-item">
            <i class="fa-solid fa-circle-user"></i>
            <span>Admin</span>
        </div>
    </div>
</header>