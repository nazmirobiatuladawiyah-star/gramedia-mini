@extends('layout.app')

@push('styles')
    <style>
        .slick-prev:before, .slick-next::before{
            color: #333;
        }
    </style>
@endpush

@section('content')

    <div class="container py-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- CAROUSEL --}}
        <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" aria-label="Slide 1"
                    aria-current="true" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt src="https://i.pinimg.com/736x/eb/0c/38/eb0c386582bcf8aeb0b1e487720bc5ac.jpg">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt src="https://i.pinimg.com/736x/5d/d7/91/5dd791aa1045daae8f97335f988a3873.jpg" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt src="https://i.pinimg.com/736x/23/92/74/23927477f492bae78da889b75862211f.jpg" />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-sample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel-sample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        {{-- PAKET LANGGANAN (3 TERBARU & WARNA DINAMIS FIELD COLOR) --}}
        <div class="mt-5">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge bg-yellow text-yellow-fg p-2"><i class="fa-solid fa-crown fs-3"></i></span>
                <h2 class="mt-2 text-dark fw-bold">Paket Langganan</h2>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse($subscriptionPackages as $package)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 text-center py-5 h-100 text-white"
                             style="background-color: {{ $package->color }} !important; border-radius: 16px;">

                            <h2 class="fw-bold text-uppercase">{{ $package->name_package }}</h2>
                            <p class="fw-bold text-light text-uppercase mb-2">{{ $package->package_type }}</p>

                            <div>
                                <small>Rp</small>
                                <span class="fw-bold" style="font-size: 2.5rem;">
                                    {{ number_format($package->price, 0, ',', '.') }}
                                </span>
                            </div>

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

        {{-- BUKU BARU DIRILIS --}}
        <div class="mt-5">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="text-dark fw-bold">Buku Baru Dirilis</h2>
            </div>

            <div id="wrapper-slider">
                @forelse($latestBooks as $book)
                    <div class="px-2">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center">
                                <img src="{{ asset($book->cover) }}"
                                     class="d-block mx-auto rounded mb-2"
                                     style="width: 120px; height: 160px; object-fit: cover;"
                                     alt="{{ $book->title }}">

                                <div class="d-flex justify-content-center gap-2 my-2">
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        <i class="fa-solid fa-file-pdf me-1"></i>PDF
                                    </span>
                                    <span class="badge bg-secondary-subtle text-secondary border">3+</span>
                                </div>

                                <div class="text-start mt-2">
                                    <span style="font-size: 0.85rem;" class="text-muted d-block text-truncate">
                                        {{ $book->writer }}
                                    </span>
                                    <h5 class="card-title text-truncate mb-1" style="font-size: 1rem;" title="{{ $book->title }}">
                                        {{ $book->title }}
                                    </h5>
                                    <div class="fw-bold text-primary">
                                        Rp {{ number_format($book->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-4 text-center text-muted">
                        <p>Belum ada buku yang dirilis.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- BUKU GRATIS --}}
        <div class="mt-5">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="text-dark fw-bold">Buku Gratis</h2>
            </div>
            <div class="row g-3">
                @forelse ($freeBooks as $freeBook)
                    <div class="col-md-4">
                        <div class="card d-flex flex-column h-100 shadow-sm border-0">
                            <div class="row g-0 flex-fill">
                                <div class="col-md-4">
                                    <img src="{{ asset($freeBook->cover) }}" class="w-100 h-100 object-fit-cover rounded-start" alt="{{ $freeBook->title }}" style="min-height: 140px;" />
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body h-100 d-flex flex-column p-3">
                                        <span class="badge bg-secondary-subtle text-secondary border mb-1" style="width: fit-content;">
                                            <i class="fa-solid fa-file-pdf me-1"></i>PDF
                                        </span>
                                        <div class="text-secondary small">{{ $freeBook->writer }}</div>
                                        <h5 class="card-title text-truncate text-dark mb-1" title="{{ $freeBook->title }}">
                                            {{ $freeBook->title }}
                                        </h5>
                                        <div class="mt-auto">
                                            <span class="fw-bold text-success">Gratis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted">
                        <p>Tidak ada buku gratis saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#wrapper-slider').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>
@endpush
