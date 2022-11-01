<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $table = "todos";
    protected $fillable = [
        'author',
        'title',
        'slug',
        'description',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id');
    }
}
