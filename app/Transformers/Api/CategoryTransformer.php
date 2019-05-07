<?php

namespace App\Transformers\Api;

use Verta;
use App\Entities\Category;
use League\Fractal\TransformerAbstract;

use App\Transformers\Api\Users\UserNormalTransformer;

class CategoryTransformer extends TransformerAbstract
{
  protected $defaultIncludes = ['parent', 'images', 'image', 'cover', 'references', 'related', 'writer', 'writer2'];

  public function transform(Category $model)
  {    	
  	$d = Verta::instance($model->created_at->toIso8601String())->formatJalaliDate();

    return [
        'id' => $model->id,
        'slug' => $model->slug,      
        'name' => $model->name,
        'menu' => $model->menu,
        'link' => $model->link,
        'parent_id' => $model->parent_id,
        'descendants' => $model->children,
        'keywords' => $model->keywords,        
        'description' => $model->description,        
        'content' => $model->content,        
        'old_content' => $model->old_content,      
        'tags' => $model->tags,  
        'writer_id' => $model->writer_id,
        'writer_id_2' => $model->writer_id_2,
        'type' => $model->type,
        'created_at' => $model->created_at->toIso8601String(),
        'created_at_persian' => $d
    ];
  }

  public function includeParent(Category $model)
  {
      if ($model->parent_id) {
        $parent = $model->getAncestors()->first()->where('id', $model->parent_id)->first();
        
        return $this->item($parent, new CategoryTransformer());
      } else {
          return null;
      }
  }

  public function includeImages(Category $model)
  {
    return $this->collection($model->getMedia('images'), new MediaTransformer());
  }

  public function includeCover(Category $model)
  {
    if ($model->getMedia('cover')->first()) {
      return $this->item($model->getMedia('cover')->first(), new MediaTransformer());
    } else {
      return null;
    }
  }

  public function includeImage(Category $model)
  {
    if ($model->getMedia('image')->first()) {
      return $this->item($model->getMedia('image')->first(), new MediaTransformer());
    } else {
      return null;
    }
  }

  public function includeReferences(Category $model)
  {
    return $this->collection($model->references, new ReferenceTransformer());
  }

  public function includeRelated(Category $model)
  {
    return $this->collection($model->related, new RelatedTransformer());
  }

  public function includeWriter(Category $model)
  {
    if ($model->writer_id) {
      return $this->item($model->writer, new UserNormalTransformer());
    } else {
      return null;
    }
  }

  public function includeWriter2(Category $model)
  {
    if ($model->writer_id_2) {
      return $this->item($model->writer2, new UserNormalTransformer());
    } else {
      return null;
    }
  }
}
