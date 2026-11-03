@extends('layout.app')

@section('content')
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header">
                <h1 class="h2 mb-0">Edit Kategori Buku</h1>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.book-categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}"
                            maxlength="255"
                            required
                            autofocus
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.book-categories.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
