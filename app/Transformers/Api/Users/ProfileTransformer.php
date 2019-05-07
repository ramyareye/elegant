<?php

namespace App\Transformers\Api\Users;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

/**
 * Class ProfileTransformer.
 */
class ProfileTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['roles', 'avatar'];

    /**
     * @param User $model
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'email' => $model->email,
            'family' => $model->family,            
            'mobile' => $model->mobile                  
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

    public function includeAvatar(User $model)
      {
        if ($model->getMedia('avatar')->first()) {
          return $this->item($model->getMedia('avatar')->first(), new MediaTransformer());
        } else {
          return null;
        }
      }
}
