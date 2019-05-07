<?php

namespace App\Transformers\Api\Users;

use Verta;
use App\Entities\User;
use League\Fractal\TransformerAbstract;

/**
 * Class AdminTransformer.
 */
class AdminTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['roles', 'avatar'];

    /**
     * @param Admin $model
     * @return array
     */
    public function transform(User $model)
    {
        $d = Verta::instance($model->created_at->toIso8601String())->formatJalaliDate();

        if ($model->birthdate) {
            $b = Verta::instance($model->birthdate->toIso8601String())->formatJalaliDate();
        } else { 
            $b = '';
        }

        return [
            'identifier' => $model->id,
            'id' => $model->uuid,
            'name' => $model->name,
            'family' => $model->family,
            'about' => $model->about,
            'email' => $model->email,
            'mobile' => $model->mobile,
            'avatar_id' => $model->avatar_id,
            'birthdate' => $model->birthdate,
            'birthdate_persian' => $b,
            'gender' => $model->gender,
            'active' => $model->active,
            'created_at' => $model->created_at->toIso8601String(),
            'created_at_persian' => $d

        ];
    }

    /**
     * @param Admin $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRoles(User $model)
    {
        return $this->collection($model->roles, new RoleTransformer());
    }
}
