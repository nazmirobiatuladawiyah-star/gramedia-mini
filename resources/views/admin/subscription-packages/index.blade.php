@extends('layout.app')

@section('content')

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Paket Langganan</h1>
            <a href="{{ route('admin.subscription-packages.create') }}" class="btn btn-primary mb-3">
                Tambah Paket Langganan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="subscriptionPackages-table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA PAKET LANGGANAN</th>
                            <th>DESKRIPSI</th>
                            <th>HARGA</th>
                            <th>WARNA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- diisi otomatis oleh DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#subscriptionPackages-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.subscription-packages.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name_package', name: 'name_package' },
                    { data: 'description', name: 'description', defaultContent: '-' },
                    { data: 'price', name: 'price' },
                    { data: 'color_display', name: 'color' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
