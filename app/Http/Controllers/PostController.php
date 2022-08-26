<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Post;
use \App\Models\Category;
use \App\Models\User;

class PostController extends Controller
{
    public function index() {

        $title = '';

        // INI UNTUK NANGKEP SLUG KALAU USER MENCET NAMA CATEGORY ATAU NAMA USER JADI MUNCUL POST YANG BERKAITAN
        // Kalau ada request category tertentu, title berubah, ini yang dikirim adalah slugnya, cara kirim ada di file categories.blade.php
        if(request('category')) {
            $category = Category::firstWhere('slug', request('category')); // dimana slug sama dengan request category yg dipilih
            $title = "in " . $category->name;
        } 
        
        // Kalau ada request user tertentu
        if(request('user')) {
            $user = User::firstWhere('id', request('user'));
            $title = "by " . $user->name;
        }

        // return file posts
        return view('posts',[ // return file posts.blade.php
            "title" => "All Posts " . $title,
            "active" => "posts",
            "p" => Post::latest()->filter(request(['search','category','user']))->paginate(5)->withQueryString() // udah otomatis include with eager loading
            // filter itu ambil dari scopeFilter di model, kalau gaada filter yauda all post
            // latest untuk ngambil dari yang paling terakhir, request itu sesuai masukkan, paginate untuk pagination
        ]);
    }

    public function show(Post $post) { // isinya harus sama kayak di route
        return view('post', [
            "title" => "Single Post",
            "active" => "posts",
            "posts" => $post, // ini yang di return $posts dalam bentuk array yang ditangkep new_post
            // posts ini variable array nanti bisa diambil isinya
        ]);
    }
}
