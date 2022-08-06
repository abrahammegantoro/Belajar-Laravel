@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
  <div class="col-lg-4">
    <main class="form-registration w-100 m-auto">
      <h1 class="h3 mb-3 fw-normal text-center">Register</h1>
        <form action="/register" method="post">
          @csrf
            <div class="form-floating">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" required value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-floating">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" required value="{{ old('username') }}">
                @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-floating">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
        </form>
        <small class="d-block text-center mt-2">Already Registered? <a href="/register">Login!</a></small>
      </main>
  </div>
</div>



@endsection