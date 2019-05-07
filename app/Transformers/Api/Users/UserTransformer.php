<?php

namespace App\Transformers\Api\Users;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['roles', 'consultant'];

    /**
     * @param User $model
     * @return array
     */
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

    /**
     * @param User $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRoles(User $model)
    {
        return $this->collection($model->roles, new RoleTransformer());
    }

    public function includeConsultant(User $model)
    {                
        if ($model->consultant_id) {
            return $this->item($model->consultant, new UserTransformer());
        } else {
            return null;
        }
    }
}
