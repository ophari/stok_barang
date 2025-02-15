<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-white shadow-sm border-bottom">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('dashboard') }}" class="nav-link text-dark">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link text-dark">Contact</a></li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Notifications Dropdown Menu (Low Stock Products)-->
            <li class="nav-item dropdown">
                <a class="nav-link text-dark" data-bs-toggle="dropdown" href="#" id="lowStockNotification">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <span class="navbar-badge badge bg-danger d-none" id="lowStockCount">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-sm">
                    <span class="dropdown-item dropdown-header" id="lowStockTitle">Low Stock Products</span>
                    <div class="dropdown-divider"></div>
                    <div id="lowStockList">
                        <p class="dropdown-item text-muted text-center">Loading...</p>
                    </div>
                </div>
            </li>
            <!--end::Notifications Dropdown Menu-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle text-dark" data-bs-toggle="dropdown">
                    <img src="{{ Vite::asset('resources/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow-sm" width="30" />
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-sm">
                    <li class="user-header text-bg-light text-center">
                        <img src="{{ Vite::asset('resources/img/user2-160x160.jpg') }}" class="rounded-circle shadow-sm" alt="User Image" />
                        <p class="mt-2">{{ Auth::user()->name }} - {{ Auth::user()->email }}</p>
                    </li>
                    <li class="user-footer text-center">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->

<!-- JavaScript untuk Fetch Notifikasi Stok Rendah -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lowStockList = document.getElementById("lowStockList");
        let lowStockCount = document.getElementById("lowStockCount");
        let lowStockTitle = document.getElementById("lowStockTitle");

        fetch("{{ route('lowStock.notifications') }}")  // Menggunakan route helper
            .then(response => response.json())
            .then(data => {
                lowStockList.innerHTML = "";
                if (data.length > 0) {
                    lowStockCount.classList.remove("d-none");
                    lowStockCount.textContent = data.length;
                    lowStockTitle.textContent = `Low Stock Products (${data.length})`;

                    data.forEach(product => {
                        let listItem = `
                            <a href="{{ route('products.index') }}" class="dropdown-item">
                                <i class="bi bi-box-seam text-warning"></i> ${product.name}
                                <span class="float-end text-danger fw-bold">${product.stock} Left</span>
                            </a>
                            <div class="dropdown-divider"></div>`;
                        lowStockList.innerHTML += listItem;
                    });
                } else {
                    lowStockCount.classList.add("d-none");
                    lowStockList.innerHTML = `<p class="dropdown-item text-muted text-center">All stocks are sufficient.</p>`;
                }
            })
            .catch(error => {
                console.error("Error fetching low stock data:", error);
                lowStockList.innerHTML = `<p class="dropdown-item text-danger text-center">Error loading data</p>`;
            });
    });
</script>


