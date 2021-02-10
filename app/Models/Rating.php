<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['rate', 'book_id', 'user_id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}