@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-4">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <main class="form-signin w-100 m-auto">
                <h1 class="h3 mb-3 fw-normal text-center">Forgot Password</h1>
                <form action="{{ route('password_email') }}" method="post"> {{--  ini actionnya samain kayak yang di routes web.php --}}
                    @csrf
                    <div class="form-floating">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror " id="email"
                            name="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Reset Password</button>
                </form>
            </main>
        </div>
    </div>
@endsection
