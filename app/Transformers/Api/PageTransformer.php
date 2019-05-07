<?php

namespace App\Transformers\Api;

use Verta;
use App\Entities\Page;
use League\Fractal\TransformerAbstract;

/**
 * Class PageTransformer.
 */
class PageTransformer extends TransformerAbstract
{
  protected $defaultIncludes = ['parent', 'images', 'cover', 'image'];
  
  public function transform(Page $model)
  {    	

  	$d = Verta::instance($model->created_at->toIso8601String())->formatJalaliDate();

    return [
        'id' => $model->id,
        'title' => $model->title,
        'slug' => $model->slug,
        'excerpt' => $model->excerpt,
        'body' => $model->body,
        'visible' => $model->visible,
        'children' => $model->children,
        'active' => $model->active,
        'type' => $model->type,
        'sidebar' => $model->sidebar,
        'parent_id' => $model->parent_id,
        'created_at' => $model->created_at->toIso8601String(),
        'created_at_persian' => $d
    ];
  }

  public function includeParent(Page $model)
  {
    if ($model->parent_id) {
      return $this->item($model->parent, new PageTransformer());
    }
  }

  public function includeImages(Page $model)
  {
    return $this->collection($model->getMedia('images'), new MediaTransformer());
  }

  public function includeCover(Page $model)
  {
    if ($model->getMedia('cover')->first()) {
      return $this->item($model->getMedia('cover')->first(), new MediaTransformer());
    } else {
      return null;
    }
  }

  public function includeImage(Page $model)
  {
    if ($model->getMedia('image')->first()) {
      return $this->item($model->getMedia('image')->first(), new MediaTransformer());
    } else {
      return null;
    }
  }
}
