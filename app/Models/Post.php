<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory, Sluggable;

    // biar bisa massive create
    protected $guarded = ['id'];

    // eager loading, biar querynya ga banyak
    protected $with = ['user','category'];

    public function scopeFilter($query, array $filters) { // scopeFilter berarti cari sesuai filter yang dimasukkin


        // SEARCH BAR
        // request untuk nangkep keyword sesuai name pada form. Kalau ada request
        $query->when($filters['search'] ?? false, function($query, $search) { // kalau true $filters['search'], nanti $filters itu jadi request
            // function($query, $search) explanation => $query merujuk ke $query di awal sebelum when, $search merujuk ke $filters['search']

            return $query->where('title','like','%' . $search . '%') // query tampilan yang dihasilkan
                        ->orWhere('body','like','%' . $search . '%');
        });
    
        $query->when($filters['category'] ?? false, function($query, $category) { // kalau ada filters namenya category, ambil dari url ?category=...
            
            // whereHas berarti kalau querynya punya relationship dengan category, kita akan melakukan apa
            return $query->whereHas('category', function($query) use ($category) {  // $category dan query ini diambil dari yang diatas
                $query->where('slug',$category); // karena url untuk category dalam bentuk slug, maka dicari dengan slug
            });
        });

        $query->when($filters['user'] ?? false, fn($query, $user) => // kalau true $filters['user']
            $query->whereHas('user', fn($query) => // kembalikan user dengan id sesuai yang dikirim
                $query->where('id',$user)
            )
        );
    }

    public function category() {
        // connect ke apa dijadiin nama function

        return $this->belongsTo(Category::class); // satu post punya satu category

    }

    public function user() {
        return $this->belongsTo(User::class); // satu post buatan satu user
    }

    // kebalikannya fillable
    // protected $guarded = ['variable'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
