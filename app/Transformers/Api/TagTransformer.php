<?php

namespace App\Transformers\Api;

use App\Entities\Tg;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{

  public function transform(Consult $model)
  {
    return [
        'id' => $model->id,
        'name' => $model->name
    ];
  }
}
