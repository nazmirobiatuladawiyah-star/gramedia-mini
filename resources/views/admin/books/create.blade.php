@extends('layout.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Manajemen katalog</div>
                        <h2 class="page-title">Tambah Buku</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-title">Periksa kembali data buku</div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">Informasi Buku</h3>
                                <div class="text-secondary">Lengkapi informasi dasar, kategori, dan sampul buku.</div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="title" class="form-label required">Judul Buku</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" placeholder="Masukkan judul buku" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="writer" class="form-label required">Penulis</label>
                                    <input type="text" name="writer" id="writer"
                                        class="form-control @error('writer') is-invalid @enderror"
                                        value="{{ old('writer') }}" placeholder="Nama penulis" required>
                                    @error('writer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="publisher" class="form-label required">Penerbit</label>
                                    <input type="text" name="publisher" id="publisher"
                                        class="form-control @error('publisher') is-invalid @enderror"
                                        value="{{ old('publisher') }}" placeholder="Nama penerbit" required>
                                    @error('publisher')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="price" class="form-label required">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="price" id="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}" min="0" placeholder="0" required>
                                    </div>
                                    @error('price')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="release_date" class="form-label required">Tanggal Rilis</label>
                                    <input type="date" name="release_date" id="release_date"
                                        class="form-control @error('release_date') is-invalid @enderror"
                                        value="{{ old('release_date') }}" required>
                                    @error('release_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="page_of_book" class="form-label required">Jumlah Halaman</label>
                                    <div class="input-group">
                                        <input type="number" name="page_of_book" id="page_of_book"
                                            class="form-control @error('page_of_book') is-invalid @enderror"
                                            value="{{ old('page_of_book') }}" min="1" placeholder="Contoh: 240" required>
                                        <span class="input-group-text">halaman</span>
                                    </div>
                                    @error('page_of_book')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="book_category_id" class="form-label required">Kategori Buku</label>
                                    <select name="book_category_id" id="book_category_id"
                                        class="form-select @error('book_category_id') is-invalid @enderror" required>
                                        <option value="">Pilih kategori</option>
                                        @foreach ($bookCategory as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('book_category_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="language" class="form-label required">Bahasa</label>
                                    <select name="language" id="language"
                                        class="form-select @error('language') is-invalid @enderror" required>
                                        <option value="">Pilih bahasa</option>
                                        @foreach (['Indonesia', 'Inggris', 'English', 'Arabic'] as $language)
                                            <option value="{{ $language }}"
                                                {{ old('language') === $language ? 'selected' : '' }}>
                                                {{ $language }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="cover" class="form-label required">Sampul Buku</label>
                                    <input type="file" name="cover" id="cover"
                                        class="form-control @error('cover') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" required>
                                    <div class="form-hint">Format JPG, PNG, GIF, atau SVG.</div>
                                    @error('cover')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="cover-preview-wrapper" class="mt-3 d-none">
                                        <img id="cover-preview" src="" alt="Pratinjau sampul"
                                            class="rounded border bg-light p-1"
                                            style="max-height: 220px; max-width: 160px; object-fit: contain;">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <div id="description" class="book-description-editor"></div>
                                    <input type="hidden" name="description" id="description-input"
                                        value="{{ old('description') }}">
                                    @error('description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer book-form-footer">
                            <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i>
                                Simpan Buku
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .book-description-editor {
            width: 100%;
            min-width: 0;
            background: var(--tblr-bg-surface);
            border: 1px solid var(--tblr-border-color);
            border-radius: var(--tblr-border-radius);
            overflow: hidden;
        }

        .book-description-editor .ql-toolbar.ql-snow {
            display: flex;
            flex-wrap: wrap;
            gap: .25rem;
            border: 0;
            border-bottom: 1px solid var(--tblr-border-color);
        }

        .book-description-editor .ql-toolbar .ql-formats {
            margin-right: .25rem;
        }

        .book-description-editor .ql-editor {
            min-height: 160px;
            max-height: 320px;
            overflow-y: auto;
            overflow-wrap: anywhere;
            word-break: break-word;
            white-space: pre-wrap;
        }

        .book-description-editor .ql-editor img,
        .book-description-editor .ql-editor video {
            max-width: 100%;
            height: auto;
        }

        .book-form-footer {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: .5rem;
        }

        .book-form-footer .btn {
            flex: 0 0 auto;
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {
            .book-form-footer .btn {
                flex: 1 1 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.8/purify.min.js"></script>
    <script>
        const descriptionEditor = new Quill('#description', {
            theme: 'snow',
            placeholder: 'Tambahkan ringkasan atau deskripsi buku...'
        });
        const descriptionInput = document.getElementById('description-input');

        if (descriptionInput.value) {
            descriptionEditor.clipboard.dangerouslyPasteHTML(
                DOMPurify.sanitize(descriptionInput.value)
            );
        }

        descriptionEditor.on('text-change', function() {
            descriptionInput.value = DOMPurify.sanitize(descriptionEditor.root.innerHTML);
        });

        document.getElementById('cover').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('cover-preview');
            const wrapper = document.getElementById('cover-preview-wrapper');

            if (!file) {
                preview.removeAttribute('src');
                wrapper.classList.add('d-none');
                return;
            }

            preview.src = URL.createObjectURL(file);
            wrapper.classList.remove('d-none');
        });
    </script>
@endpush
