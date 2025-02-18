<aside class="app-sidebar bg-body-secondary shadow">
    {{-- <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ Vite::asset('resources/img/logo.png') }}" alt="Admin Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div> --}}

    <div class="sidebar-wrapper">
        <nav>
            <ul class="nav sidebar-menu flex-column" role="menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('invoices.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-fill"></i>
                        <p>Invoices</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transactions.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>Transactions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-bar-chart-fill"></i>
                        <p>Reports</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
