<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1)
 */
class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['model_type', 'model_id', 'path', 'name', 'alt'];
    protected $hidden = ['created_at', 'updated_at'];
}
