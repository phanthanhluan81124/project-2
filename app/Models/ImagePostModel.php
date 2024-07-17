<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePostModel extends Model
{
    use HasFactory;
    protected $table = 'posts_image';
    protected $fillable = 
    [
        'image_name',
        'post_id'
    ];
}
