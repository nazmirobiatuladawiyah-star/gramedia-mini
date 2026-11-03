<header class="navbar navbar-expand-md d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- BEGIN NAVBAR LOGO -->
            <a href="{{ route('home') }}" aria-label="Tabler" class="navbar-brand navbar-brand-autodark me-3">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTfj9hp3HOViAnrg8F47GnaATetdnm8YezaWv_o_dMSjg&s=10"
                    width="110" height="32" alt="Tabler" class="navbar-brand-image"> Ebooks
            </a>
            <!-- END NAVBAR LOGO -->
            {{-- search bar --}}
            <div class="navbar-nav mx-auto w-50 mt-3">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.book-categories.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.book-categories.index') }}" class="nav-link">Kategori Buku</a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.subscription-packages.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.subscription-packages.index') }}" class="nav-link">
                            Paket Langganan
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.books.index') }}" class="nav-link">Buku</a>
                    </li>
                @else
                    {{-- dropdown --}}
                    <div class="dropdown">
                        <a href="#" class="btn btn-light dropdown-toggle me-2"
                            data-bs-toggle="dropdown">Kategori</a>
                        <div class="dropdown-menu dropdown-menu-card" style="min-width: 320px; max-width: 600px">
                            <div class="p-3">
                                <div class="row g-2">
                                    
                                    {{-- kategori di navbar  --}}
                                    @forelse ($categories as $category)
                                        <div class="col-6 col-md-4">
                                            <a href="{{ route('category.books', $category->id) }}"
                                                class="card card-sm card-link h-100">
                                                <div class="card-body py-2">
                                                    {{ $category->name }}
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="text-secondary text-center py-2">
                                                Belum ada kategori buku.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- search bar --}}
                    <div class="input-icon w-100 ">
                        <input type="text" value="" class="form-control form-control-rounded"
                            placeholder="cari Judul, Produk, Penulis..." />
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true" focusable="false" class="icon">
                                <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                        </span>
                    </div>
                    {{-- icon keranjang --}}
                    <div class="ms-2">
                        <button class="btn btn-light rounded-circle" type="button" aria-label="Keranjang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true" focusable="false">
                                <circle cx="9" cy="19" r="2"></circle>
                                <circle cx="17" cy="19" r="2"></circle>
                                <path d="M3 4h2l2.5 10h9.5l2-7H7"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            {{-- button login --}}
            <div class="navbar-nav flex-row order-md-last gap-2">
                {{-- Auth::check() : untuk ngecek apakah user sudah login atau belum --}}
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary " >Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-outline">Daftar</a>
                @endif
            </div>
    </header>
