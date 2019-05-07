<?php

namespace App\Entities;

use \App\Entities\Tag;
use \App\Entities\User;
use \App\Entities\Comment;
use \App\Entities\Category;
use \App\Entities\Reference;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Experience.
 */
class Post extends Model implements HasMedia
{
	protected $table = 'posts';

	protected $guarded = ['id'];

	protected $dates = ['deleted_at'];

	protected $fillable = [
    'title',
    'slug',
    'excerpt',
    'body',
    'writer_id',
    'keywords',
    'description',
    'visible',
    'deleted_at'
  ];

  use HasSlug;
  use HasMediaTrait;
  
  /**
   * Get the options for generating the slug.
   */
  public function getSlugOptions() : SlugOptions
  {
      return SlugOptions::create()
          ->generateSlugsFrom('title')
          ->saveSlugsTo('slug');
  }

  public function registerMediaConversions(Media $media = null)
  {
      $this->addMediaConversion('thumb')
          ->width(64)
          ->height(64);

      $this->addMediaConversion('small')
          ->width(150)
          ->height(150);

      $this->addMediaConversion('medium')
          ->width(300)
          ->height(300);

      $this->addMediaConversion('large')
          ->width(800)
          ->height(800);
  }

  public function writer()
  {
      return $this->belongsTo(User::class, 'writer_id');
  }

  public function categories()
  {
      return $this->morphToMany(Category::class, 'categorizable');
  }

  public function comments()
  {
      return $this->morphToMany(Comment::class, 'commentable');
  }

  public function tags()
  {
      return $this->morphToMany(Tag::class, 'taggable');
  }

  public function cover()
  {
      return $this->morphOne(Media::class, 'model');
  }

  public function image()
  {
      return $this->morphOne(Media::class, 'model');
  }

  public function images()
  {
      return $this->morphMany(Media::class, 'model');
  }
}
