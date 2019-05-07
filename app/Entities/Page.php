<?php

namespace App\Entities;

use \App\Entities\User;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Category.
 */
class Page extends Model implements HasMedia
{
	protected $table = 'pages';

	protected $guarded = ['id'];

	protected $dates = ['deleted_at'];

	protected $fillable = [
    'title',
    'slug',
    'excerpt',
    'body',
    'visible',
    'parent_id',
    'children',
    'type',
    'sidebar',
    'deleted_at',
    'writer_id',
    'keywords',
    'description'
  ];

  // use HasSlug;
  use HasMediaTrait;
  
  /**
   * Get the options for generating the slug.
   */
  // public function getSlugOptions() : SlugOptions
  // {
  //     return SlugOptions::create()
  //         ->generateSlugsFrom('title')
  //         ->saveSlugsTo('slug');
  // }

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

  public function images()
  {
      return $this->morphMany(Media::class, 'model');
  }

  public function siblings()
  {
      return $this->hasMany('App\Entities\Page', 'parent_id');
  }

  public function parent()
  {
      return $this->belongsTo('App\Entities\Page', 'parent_id');
  }  

  public function cover()
  {
      return $this->morphOne(Media::class, 'model');
  }

  public function image()
  {
      return $this->morphOne(Media::class, 'model');
  }

  public function writer()
  {
      return $this->belongsTo(User::class, 'writer_id');
  }
}
