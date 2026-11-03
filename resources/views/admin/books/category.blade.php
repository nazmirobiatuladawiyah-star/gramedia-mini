@extends('layout.app')

@section('content')
<div class="container py-4">

    <!-- 1. Nama Kategori yang Sedang Diakses -->
    <h3 class="mb-4 fw-bold">Buku {{ $category->name }}</h3>

    <!-- 2. Form Pencarian & Dropdown Sortir -->
    <form action="{{ route('category.books', $category->id) }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-center">

            <!-- Search Bar untuk mencari judul buku atau penulis -->
            <div class="col-md-6 col-12">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="cari judul atau penulis"
                           value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('category.books', $category->id) }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </div>

            <!-- Dropdown Pengurutan (Nilai Tambahan) -->
            <div class="col-md-4 col-12 ms-auto">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value=""> Urutkan Berdasarkan </option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga termahal</option>
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Buku terbaru</option>
                </select>
            </div>
        </div>
    </form>

    <!-- 3. Daftar Buku dengan Kategori Terkait -->
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
        @forelse ($books as $book)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ asset($book->cover) }}"
                         class="card-img-top rounded"
                         alt="{{ $book->title }}"
                         style="height: 210px; object-fit: cover;">
                    <div class="card-body p-2 d-flex flex-column">
                        <span class="badge bg-secondary-subtle text-secondary border mb-1" style="width: fit-content; font-size: 10px;">
                            <i class="fa-solid fa-file-pdf me-1"></i>PDF
                        </span>
                        <small class="text-muted text-truncate">{{ $book->writer }}</small>
                        <h6 class="card-title text-truncate mb-1" title="{{ $book->title }}" style="font-size: 14px;">
                            {{ $book->title }}
                        </h6>
                        <span class="text-primary fw-bold mt-auto" style="font-size: 13px;">
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 w-100">
                <div class="alert alert-warning text-center">
                    Tidak ada buku yang ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>

    <div class="mt-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-yellow text-yellow-fg p-2"><i class="fa-solid fa-crown fs-3"></i></span>
            <h2 class="mt-2 text-dark fw-bold">Paket Langganan</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($subscriptionPackages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-5 h-100 text-white"
                         style="background-color: {{ $package->color }} !important;">
                        <h2 class="fw-bold text-uppercase">{{ $package->name_package }}</h2>
                        <p class="fw-bold text-light text-uppercase mb-2">{{ $package->package_type }}</p>
                        <div>
                            <small>Rp</small>
                            <span class="fw-bold" style="font-size: 2.5rem;">
                                {{ number_format($package->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="px-4 my-3 text-light">{{ $package->description }}</p>
                        <div class="fw-bold text-light mt-auto fs-5">{{ $package->days }} Hari</div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-4 text-center text-muted">
                    <p>Belum ada paket langganan yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

