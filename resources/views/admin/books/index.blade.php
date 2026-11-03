@extends('layout.app')

@section('content')
    <div class="container-xl py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="text-secondary">Manajemen katalog</div>
                <h1 class="h2 mb-0">Data Buku</h1>
            </div>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Buku</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Daftar Buku</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter table-hover card-table" id="data-buku">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sampul</th>
                            <th>Judul</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal detail --}}
    <div class="modal modal-blur fade" id="modalDetailBook" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                {{-- header --}}
                <div class="modal-header">
                    <h5 class="modal-title">Detail Informasi Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Body --}}

                <div class="modal-body">
                    <div class="row g-3">
                        {{-- column cover --}}
                        <div class="col-12 col-sm-4 text-center">
                            <img id="detail-cover" src="" alt="Cover Buku"
                                class="rounded shadow-sm border img-fluid"
                                style="max-height: 280px; max-width: 100%; width: auto; object-fit: contain;">
                        </div>

                        {{-- column info --}}
                        <div class="col-12 col-sm-8">
                            <h3 id="detail-title" class="mb-1 text-primary fw-bold"></h3>

                            <div class="mb-3">
                                <span id="detail-category" class="badge bg-blue-lt"></span>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="text-secondary small">Harga</div>
                                    <div id="detail-price" class="text-success fw-bold"></div>
                                </div>

                                <div class="col-6">
                                    <div class="text-secondary small">Penulis</div>
                                    <div id="detail-writer" class="fw-semibold"></div>
                                </div>

                                <div class="col-6">
                                    <div class="text-secondary small">Penerbit</div>
                                    <div id="detail-publisher" class="fw-semibold"></div>
                                </div>

                                <div class="col-6">
                                    <div class="text-secondary small">Bahasa</div>
                                    <div id="detail-language" class="fw-semibold"></div>
                                </div>

                                <div class="col-6">
                                    <div class="text-secondary small">Tanggal Rilis</div>
                                    <div id="detail-release-date" class="fw-semibold"></div>
                                </div>

                                <div class="col-6">
                                    <div class="text-secondary small">Jumlah Halaman</div>
                                    <div id="detail-pages" class="fw-semibold"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                            <h4 class="subheader mb-2">Deskripsi Buku</h4>
                            <div id="detail-description" class="book-detail-description"></div>
                        </div>
                    </div>
                </div>

                {{-- footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #data-buku {
            min-width: 720px;
        }

        #data-buku td {
            vertical-align: middle;
        }

        .book-table-cover {
            display: block;
            width: 48px;
            height: 64px;
            margin: 0 auto;
            border-radius: .25rem;
            object-fit: cover;
        }

        .book-table-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: .375rem;
            min-width: 190px;
        }

        .book-table-actions form {
            margin: 0;
        }

        .book-detail-description {
            max-height: 240px;
            overflow: auto;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: normal;
            padding: 1rem;
            border: 1px solid var(--tblr-border-color);
            border-radius: var(--tblr-border-radius);
            background: var(--tblr-bg-surface-secondary);
        }

        .book-detail-description img,
        .book-detail-description video,
        .book-detail-description iframe {
            max-width: 100%;
        }

        .book-detail-description p:last-child {
            margin-bottom: 0;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.8/purify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data-buku').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'coverImg',
                        name: 'coverImg',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#data-buku').on('click', '.btn-detail', function() {
                const book = JSON.parse(this.dataset.book);
                const setText = (selector, value) => {
                    document.querySelector(selector).textContent = value || '-';
                };

                document.getElementById('detail-cover').src = book.cover || '';
                setText('#detail-title', book.title);
                setText('#detail-category', book.category);
                setText('#detail-price', book.price === null
                    ? '-'
                    : 'Rp ' + Number(book.price).toLocaleString('id-ID'));
                setText('#detail-writer', book.writer);
                setText('#detail-publisher', book.publisher);
                setText('#detail-language', book.language);
                setText('#detail-release-date', book.releaseDate);
                setText('#detail-pages', book.pages ? `${book.pages} halaman` : '-');
                document.getElementById('detail-description').innerHTML =
                    DOMPurify.sanitize(book.description || '');

                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('modalDetailBook')
                ).show();
            });
        });
    </script>
@endpush
