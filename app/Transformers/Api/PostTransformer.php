<?php

namespace App\Transformers\Api;

use Verta;
use App\Entities\Post;
use App\Transformers\Api\MediaTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\Api\CategoryTransformer;

/**
 * Class PostTransformer.
 */
class PostTransformer extends TransformerAbstract
{
  protected $defaultIncludes = ['categories', 'images'];

  public function transform(Post $model)
  {    	

  	$d = Verta::instance($model->created_at->toIso8601String())->formatJalaliDate();

    return [
        'id' => $model->id,
        'title' => $model->title,
        'slug' => $model->slug,
        'excerpt' => $model->excerpt,
        'body' => $model->body,
        'visible' => $model->visible,
        'created_at' => $model->created_at->toIso8601String(),
        'created_at_persian' => $d
    ];
  }

  public function includeCategories(Post $model)
  {
      return $this->collection($model->categories, new CategoryTransformer());
  }

  public function includeImages(Post $model)
  {
    return $this->collection($model->getMedia('images'), new MediaTransformer());
  }
}
