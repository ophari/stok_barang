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
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link text-dark">Home</a></li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link text-dark">Contact</a></li>
      </ul>
      <!--end::Start Navbar Links-->

      <!--begin::End Navbar Links-->
      <ul class="navbar-nav ms-auto">
          <!--begin::Notifications Dropdown Menu-->
          <li class="nav-item dropdown">
              <a class="nav-link text-dark" data-bs-toggle="dropdown" href="#">
                  <i class="bi bi-bell-fill"></i>
                  <span class="navbar-badge badge bg-danger">15</span>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-sm">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                      <i class="bi bi-envelope me-2"></i> 4 new messages
                      <span class="float-end text-secondary fs-7">3 mins</span>
                  </a>
              </div>
          </li>
          <!--end::Notifications Dropdown Menu-->

          <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle text-dark" data-bs-toggle="dropdown">
                  <img src="{{ Vite::asset('resources/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow-sm" width="30" />
                  <span class="d-none d-md-inline">Alexander</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow-sm">
                  <li class="user-header text-bg-light text-center">
                      <img src="{{ Vite::asset('resources/img/user2-160x160.jpg') }}" class="rounded-circle shadow-sm" alt="User Image" />
                      <p class="mt-2">Alexander Pierce - Web Developer</p>
                  </li>
                  <li class="user-footer text-center">
                      <a href="#" class="btn btn-sm btn-outline-primary">Profile</a>
                      <a href="#" class="btn btn-sm btn-outline-danger">Logout</a>
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
