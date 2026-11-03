@extends('layout.app')

@section('content')
    <form method="POST" action="{{ route('register.store')}}" class="form-fieldset w-50 d-block mx-auto">
        {{-- ubah jadi form (ke 1), tambah method="post" (ke 2), tambah action=" " --}}

        {{-- ini sebuah kunci agar di form bisa di ambil controller (syarat ke 3) --}}
        @csrf

        <legend class="form-label">Register</legend>

        <div class="mb-3">
            <label class="form-label required" for="fieldset-name">Nama Lengkap</label>
            <input type="text" id="fieldset-name" class="form-control @error('name') is-invalid @enderror" autocomplete="name" required name="name" />
            {{-- @error('name') is-invalid @enderror ini untuk memunculkan tanda merah kalau eror --}}
            {{-- di tambah name="name" setelah required (syarat ke 4) --}}

            {{-- munculkan error validasi : @eror('name_imput') --}}
            @error("name")
            {{-- $message : munculin tulisan errornya --}}
                <smal class="text-danger"> {{$message}}</smal>
            @enderror
        </div>

        <div class="mb-3"><label class="form-label required" for="fieldset-email">Email</label>
            <input type="email" id="fieldset-email" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required name="email" />
            @error("email")
                <smal class="text-danger"> {{$message}}</smal>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="fieldset-phone">Password</label>
            <input type="password" id="fieldset-phone" class="form-control @error('password') is-invalid @enderror" autocomplete="tel" name="password" />
            @error("password")
                <smal class="text-danger"> {{$message}}</smal>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary"> Kirim </button>
        {{-- syarat ke 5 --}}

    </form>
@endsection
