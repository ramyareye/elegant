<?php

namespace App\Transformers\Api\Users;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class UserNormalTransformer extends TransformerAbstract
{
    public function transform(User $model)
    {
        return [
            'identifier' => $model->id,
            'id' => $model->uuid,
            'name' => $model->name,
            'full_name' => $model->name . ' ' . $model->family,
            'email' => $model->email,
            'created_at' => $model->created_at->toIso8601String(),
            'updated_at' => $model->updated_at->toIso8601String(),
        ];
    }
}
