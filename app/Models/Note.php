<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // Define which fields can be mass-assigned
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'tags', 'shared_token'
    ];

    // Define the relationship with the User model (each note belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
