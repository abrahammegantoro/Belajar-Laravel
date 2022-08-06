<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index',[
            'posts' => Post::where('user_id', auth()->user()->id)->get() // cari post yang user_id = id user yang lagi login
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create',[
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts', // unique:posts = unik beda dari yang lain di table posts
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ]);

        if($request->file('image')) { // kalau user upload image
            $validatedData['image'] = $request->file('image')->store('post-images'); // di store = di taruh di folder post-image
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200); // strip_tags = semua tag html didalem body ilang

        Post::create($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New post has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) // request = yang baru, post = data lama
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ];

        // kalo slug yang dimasukkin ga sama kayak slug yg udah ada, maka pake slug yg baru
        if($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        
        $validatedData = $request->validate($rules);
        
        if($request->file('image')) { // kalau user upload image
            if($request->oldImage) { // Hapus gambar lama biar ga numpuk di storage
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('post-images'); // di store = di taruh di folder post-image
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200); // strip_tags = semua tag html didalem body ilang

        Post::where('id', $post->id)->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // delete file di storage
        if($post->image) { // Hapus gambar lama biar ga numpuk di storage
            Storage::delete($post->image);
        }

        // delete file di table nya
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success', 'Post has been deleted!');
    }

    public function checkSlug(Request $request) {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title); // title diambil dari script yang ?title = + title.value

        return response()->json(['slug' => $slug]); // dikirim balik ke script jadi data.slug
    }
}
