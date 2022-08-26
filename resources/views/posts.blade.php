@extends('layouts.main')

@section('container')

    <h1 class="mb-3 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="/blog" method="get">
                <!-- method get adalah method default, gaditulis juga gapapa -->

                @if (request('category')) {{--  Kalau user ngeklik salah satu category sehingga ingin memunculkan post dengan category tsb --}}
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('user')) {{--  Kalau user ngeklik salah satu user sehingga ingin memunculkan post dengan user tsb --}}
                    <input type="hidden" name="user" value="{{ request('user') }}">
                @endif

            {{-- SEARCH BAR --}}
                <div class="input-group mb-3">
                    {{-- ini nambahin request yang udah ada d url, atau belum ada sama sekali juga gapapa, nanti otomatis nambah & di urlnya --}}
                    <input type="text" class="form-control" placeholder="Search..." name="search"
                        value={{ request('search') }}>
                    <button class="btn btn-danger" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>


    @if ($p->count()) {{-- kalau ada p --}}
        <div class="card mb-3">

            @if ($p[0]->image) {{--  kalau post pertama ada imagenya --}}
                <img src="{{ asset('storage/' . $p[0]->image) }}" alt="{{ $p[0]->category->name }}" class="img-fluid mt-3">
            @else
                <img src="https://source.unsplash.com/1200x400?{{ $p[0]->category->name }}" class="card-img-top"
                    alt="{{ $p[0]->category->name }}">
            @endif

            <div class="card-body">

                <h2 class="card-title"><a href="/post/{{ $p[0]->slug }}" class="text-dark">{{ $p[0]->title }}</a></h2>

                {{--  masuk ke request() --}}
                <p>By : <a href="/blog?user={{ $p[0]->user->id }}">{{ $p[0]->user->name }}</a> in <a
                        href="/blog?category={{ $p[0]->category->slug }}">{{ $p[0]->category->name }}</a></p>

                <p class="card-text">{{ $p[0]->excerpt }}</p>

                <p class="card-text"><small class="text-muted">{{ $p[0]->created_at->diffForHumans() }}</small></p>
                <!-- Keren coyyy diffForHumans() -->

                <a href="/post/{{ $p[0]->slug }}" class="text-decoration-none btn btn-primary">Read More</a>
            </div>
        </div>


        <div class="container">
            <div class="row">
                @foreach ($p->skip(1) as $post)
                    <!-- artinya ngeskip yang pertama -->
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="position-absolute bg-dark px-3 py-2" style="background-color: rgba(0, 0, 0, 0.7)"><a
                                    href="/blog?category={{ $post->category->slug }}"
                                    class="text-white text-decoration-none">{{ $post->category->name }}</a></div>
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}"
                                    class="img-fluid mt-3">
                            @else
                                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}"
                                    class="card-img-top" alt="{{ $post->category->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>

                                <p><small class="text-muted">By : <a
                                            href="/blog?user={{ $post->user->id }}">{{ $post->user->name }}</a>
                                        {{ $post->created_at->diffForHumans() }}</small></p>
                                <p class="card-text">{{ $post->excerpt }}</p>
                                <a href="/post/{{ $post->slug }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h1 class="text-center">No Post Found.</h1>
    @endif

    {{ $p->links() }}

@endsection
