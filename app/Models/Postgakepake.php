<?php

namespace App\Models;

class Post
{
    private static $blog_posts = [
        [
        "title" => "Judul Post Pertama",
        "slug" => "judul-pertama",
        "author" => "Abraham Megantoro Samudra",
        "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, quam? Quisquam neque magni perspiciatis deleniti excepturi. Saepe, dolorum tenetur, odit sapiente rerum eligendi voluptates debitis porro quis nam provident vero."
        ],
        [
        "title" => "Judul Post Kedua",
        "slug" => "judul-kedua",
        "author" => "Judith NAS",
        "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, quam? Quisquam neque magni perspiciatis deleniti excepturi."
        ],
    ];

    public static function all() {

        return collect(self::$blog_posts); // karena static pake self
        // jadiin collection biar bisa jalanin berbagai fungsi keren & method
        // kalo object biasa pake $this->blog_posts
    }

    public static function find($slug) {

        $post = static::all();
        
        return $post->firstWhere('slug', $slug); // 'slug' itu yang didalem $post
    }
}
