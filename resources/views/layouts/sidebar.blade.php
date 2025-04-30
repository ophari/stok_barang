<!--begin::Sidebar-->
<aside class="app-sidebar bg-white shadow-sm border-end">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand text-center py-3">
      <a href="{{ route('dashboard') }}" class="brand-link text-dark fw-bold">
          <img class="brand-image rounded-circle" src="{{ Vite::asset('resources/img/logohero.jpeg') }}" alt="Admin Logo" class="brand-image shadow-sm" width="40">
          <span class="brand-text ms-2">Stok Barang</span>
      </a>
  </div>

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
      <nav class="mt-2">
          <ul class="nav sidebar-menu flex-column" role="menu">
              <li class="nav-item">
                  <a href="{{ route('dashboard') }}" class="nav-link text-dark rounded {{ request()->routeIs('dashboard') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-speedometer2"></i> <p>Dashboard</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('products.index') }}" class="nav-link text-dark rounded {{ request()->routeIs('products.*') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-box-seam"></i> <p>Products</p>
                  </a>
              </li>
              <div class="nav-item">
                  <a href="{{ route('categories.index') }}" class="nav-link text-dark rounded {{ request()->routeIs('categories.*') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-tag"></i> <p>Categories</p>
                  </a>
              </div>
              <li class="nav-item">
                  <a href="{{ route('invoices.index') }}" class="nav-link text-dark rounded {{ request()->routeIs('invoices.*') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-file-earmark-text"></i> <p>Invoices</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('transactions.index') }}" class="nav-link text-dark rounded {{ request()->routeIs('transactions.*') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-clipboard-data"></i> <p>Transactions</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('reports.index') }}" class="nav-link text-dark rounded {{ request()->routeIs('reports.*') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-bar-chart"></i> <p>Reports</p>
                  </a>
              </li>
              @if(auth()->user()->role === 'supervisor')
              <li class="nav-item">
                  <a href="{{ route('users.index') }}" class="nav-link text-dark rounded {{ request()->routeIs('users.*') ? 'bg-light shadow-sm' : '' }}">
                      <i class="nav-icon bi bi-people"></i> <p>Users</p>
                  </a>
              </li>
              @endif
          </ul>
      </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
