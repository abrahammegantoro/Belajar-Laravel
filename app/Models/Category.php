<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters) {
        
        // request untuk nangkep keyword sesuai name pada form. Kalau ada request
        $query->when($filters['search'] ?? false, function($query, $search) { // kalau true $filters['search']
            return $query->where('title','like','%' . $search . '%')
                        ->orWhere('body','like','%' . $search . '%');
        });
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
