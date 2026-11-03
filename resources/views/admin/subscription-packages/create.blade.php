@extends('layout.app')

@section('content')

<div class="container py-4">
    <h2 class="mb-4">Tambah Paket Langganan</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.subscription-packages.store') }}"
                  method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">
                        Nama Paket Langganan
                    </label>
                    <input type="text" name="name_package" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"> Harga </label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label"> Warna </label>
                    <input type="color" name="color" class="form-control form-control-color" value="#22AFF5" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"> Deskripsi </label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary"> Simpan </button>

                <a href="{{ route('admin.subscription-packages.index') }}" class="btn btn-secondary"> Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
