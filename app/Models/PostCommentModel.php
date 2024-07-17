<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentModel extends Model
{
    use HasFactory;
    protected $table = 'posts_comment';
    protected $fillable =
    [
        'content',
        'user_id',
        'email',
        'name',
        'post_id'
    ];

}
