<?php

namespace App\Transformers\Api;

use Spatie\MediaLibrary\Models\Media;
use League\Fractal\TransformerAbstract;

/**
 * Class MediaTransformer.
 */
class MediaTransformer extends TransformerAbstract
{
    /**
     * @param \App\Entities\Media $model
     * @return array
     */
    public function transform(Media $model)
    {
      return [
          'id' => $model->id,
          'name' => $model->name,
          'size' => $model->size,
          'type' => $model->mime_type,
          'file_name' => $model->file_name,
          'order_column' => $model->order_column,

          'url' => [
            'main' => $model->getFullUrl(),
            'thumb' => $model->getFullUrl('thumb'),
            'small' => $model->getFullUrl('small'),
            'medium' => $model->getFullUrl('medium'),
            'large' => $model->getFullUrl('large'),
          ],

          'created_at' => $model->created_at->toIso8601String(),
      ];
    }
}
