<?php

namespace App\Entities;

use \App\Entities\Category;

use App\Support\UuidScopeTrait;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Category extends Model 
{
  use SoftDeletes;

  protected $table = 'categories';

  protected $guarded = ['id'];

  protected $dates = ['deleted_at', 'deleted_at'];

  protected $fillable = [
    'uuid',
    'name',    
    'slug',
    'menu',
    'link',
    'keywords',
    'description',
    'content',
    "visible",
    "published_at"
  ]; 

  use NodeTrait;  
  use HasMediaTrait;
  use UuidScopeTrait;  

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

  public function posts()
  {
    return $this->morphedByMany(Post::class, 'categorizable');
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
