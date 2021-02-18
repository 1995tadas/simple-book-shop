<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'book_id'];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = ucfirst($value);
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->toDateTimeString();
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
