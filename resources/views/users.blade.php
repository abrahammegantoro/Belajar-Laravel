@extends('layouts.main')

@section('container')
    <h1 class="mb-5">Users</h1>

    @foreach ($users as $user)
        <ul>
            <li>
                <h2>
                    <a href="/blog?user={{ $user->id }}">
                        <!-- kirim url -->
                        {{ $user->name }}
                    </a>
                </h2>
            </li>
        </ul>
    @endforeach
@endsection
