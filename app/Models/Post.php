<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($id)
 * @method static orderBy(string $string, string $string1)
 */
class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['name', 'slug', 'description', 'content',
        'seo_title', 'seo_description', 'seo_keywords',
        'category_id','views','rating_number','rating_value'];
    protected $with = ['category','images'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function images()
    {
        return Image::where('model_type', 'post')->where('model_id', $this->id)->get();
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
    public function deleteImages()
    {
        $images = Image::where('model_type', 'post')->where('model_id', $this->id)->get();
        foreach ($images as $image) {
            $image->delete();
        }
    }

    public static function boot(): void
    {
        // Trước khi xóa 1 post sẽ xóa các images, comments
        parent::boot();
        static::deleting(function($post){
            $post->deleteImages();
            $post->comments()->delete();
        });
    }
}
