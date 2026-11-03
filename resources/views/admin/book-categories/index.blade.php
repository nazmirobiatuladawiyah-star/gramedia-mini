@extends('layout.app')

@section('content')

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-item-center mb-3">
            <h1>Kategori Buku</h1>
            <a href="{{ route('admin.book-categories.create') }}" class="btn btn-primary mb-3"> Tambah Kategori buku </a>
        </div>

    @if (@session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="bookCategories-table">
                    <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA KATEGORI</th>
                        <th>AKSES</th>
                    </tr>
                    </thead>
                    <tbody>
                        {{-- di isi otomatis oleh datables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#bookCategories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.book-categories.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false  },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
            });
        });
    </script>

@endpush
