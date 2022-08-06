@extends('layouts.main')

@section('container')
    
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">

            <h2 class="mb-4">{{ $posts->title }}</h2>
            <p>By : <a href="/blog?user={{ $posts->user->id }}">{{ $posts->user->name }}</a> in <a href="/blog?category={{ $posts->category->slug }}">{{ $posts->category->name }}</a></p>
            
            @if($posts->image)
                <img src="{{ asset('storage/' . $posts->image) }}" alt="{{ $posts->category->name }}" class="img-fluid mt-3">
            @else
                <img src="https://source.unsplash.com/1200x400?{{ $posts->category->name }}" alt="{{ $posts->category->name }}" class="img-fluid">
            @endif
            
            <article class="my-3 fs-5">
                {!! $posts->body !!}
            </article>
            <!-- kalo mau ga pake htmlspecialchars pake kurung siku + double tanda seru -->
            
                <a href="/blog">Back to post!</a>
    
        </div>
    </div>
</div>
@endsection