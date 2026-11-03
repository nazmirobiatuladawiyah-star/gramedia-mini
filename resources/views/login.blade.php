@extends('layout.app')

@section('content')
    <form method="POST" action="{{ route('login.store')}} " class="form-fieldset w-50 d-block mx-auto">
        {{-- ubah jadi form (ke 1), tambah method="post" (ke 2), tambah action=" " --}}

        {{-- dibuat munculkan notifikasi dari register --}}

        @if(session('success'))
        {{-- tulisan session('success') di ambil dari controller bagian with() --}}
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        {{-- ini sebuah kunci agar di form bisa di ambil controller (syarat ke 3) --}}
        @csrf

        <legend class="form-label">LOGIN</legend>

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
