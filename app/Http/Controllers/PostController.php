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
        if(request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = "in " . $category->name;
        } 
        
        if(request('user')) {
            $user = User::firstWhere('id', request('user'));
            $title = "by " . $user->name;
        }

        return view('posts',[ // return file posts.blade.php
            "title" => "All Posts " . $title,
            "active" => "posts",
            "p" => Post::latest()->filter(request(['search','category','user']))->paginate(5)->withQueryString() // all nanti fungsi untuk mendapatkan semua data posts
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
