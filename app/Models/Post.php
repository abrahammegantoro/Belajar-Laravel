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
    protected $with = ['user','category'];

    public function scopeFilter($query, array $filters) {
        
        // request untuk nangkep keyword sesuai name pada form. Kalau ada request
        $query->when($filters['search'] ?? false, function($query, $search) { // kalau true $filters['search']
            return $query->where('title','like','%' . $search . '%')
                        ->orWhere('body','like','%' . $search . '%');
        });
    
        $query->when($filters['category'] ?? false, function($query, $category) { // kalau true $filters['category']
            return $query->whereHas('category', function($query) use ($category) {
                $query->where('slug',$category);
            });
        });

        $query->when($filters['user'] ?? false, fn($query, $user) => // kalau true $filters['user']
            $query->whereHas('user', fn($query) =>
                $query->where('id',$user)
            )
        );
    }

    public function category() {
        // connect ke apa dijadiin nama function

        return $this->belongsTo(Category::class);

    }

    public function user() {
        return $this->belongsTo(User::class);
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
