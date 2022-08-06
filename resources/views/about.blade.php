@extends('layouts.main')

@section('container')
    <h1>Halaman About</h1>
    <h3>{{ $name }}</h3> <!-- blade template engine -->
    <p>{{ $email }}</p>
    <img src="img/{{ $image }}" alt="{{ $name }}" width="300">
@endsection
