<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public const NO_COMMENTS = 0;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'image_id', 'content', 'deleted_at',
    ];

    protected $appends = ['image_url', 'count_of_comments'];

    /**
     * @return null
     */
    public function getImageUrlAttribute()
    {
        return $this->image()->first()
            ? $this->image->url
            : Image::DEFAULT_URL;
    }

    /**
     * @return int
     */
    public function getCountOfCommentsAttribute() // 6.2
    {
        return $this->comments->count() ?: self::NO_COMMENTS;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActual(Builder $query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithImage(Builder $query)
    {
        return $query->whereHas('image', function($query) {
            $query->whereNotNull('url');
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActiveAuthor(Builder $query)
    {
        return $query->whereHas('author', function($query) {
            $query->active();
        });
    }
}
