<?php

namespace App\Entities;

use App\Support\HasRolesUuid;
use App\Support\UuidScopeTrait;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class User.
 */
class User extends Authenticatable implements HasMedia
{
    use Notifiable, UuidScopeTrait, HasApiTokens, HasRoles, SoftDeletes, HasRolesUuid {
        HasRolesUuid::getStoredRole insteadof HasRoles;
    }

    protected $table = 'users';
    protected $guard_name = 'api';

    protected $casts = [
        'birthdate' => 'datetime'
    ];

    use HasMediaTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birthdate',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'password',
        'family',
        'description',
        'username',
        'email',
        'email_verified',
        'mobile',
        'is_mobile_verified',
        'is_charity',
        'avatar_id',
        'birthdate',
        'gender',
        'instagram',
        'facebook',
        'twitter',
        'twitter website',
        'phone',
        'fax',
        'location_id',
        'state_id',
        'city_id',
        'address',
        'last_login',
        'activated_at',
        'status',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {
        if (array_key_exists('password', $attributes)) {
            $attributes['password'] = bcrypt($attributes['password']);
        }

        $model = static::query()->create($attributes);

        return $model;
    }

    public function scopeAdmins($query)
    {
        return $query->whereHas('roles', function ($q) {
          $q->where('name', 'Admin');
        });
    }

    public function scopeModerators($query)
    {
        return $query->whereHas('roles', function ($q) {
          $q->where('name', 'Moderator');
        });
    }

    public function scopeSupports($query)
    {
        return $query->whereHas('roles', function ($q) {
          $q->where('name', 'Support');
        });
    }

    public function scopeManagers($query)
    {
        return $query->whereHas('roles', function ($q) {
          $q->where('name', 'Managers');
        });
    }

    public function scopeUsers($query)
    {
        return $query->whereHas('roles', function ($q) {
          $q->where('name', 'Users');
        });
    }

    public function categories()
    {
      return $this->hasMany('App\Entities\Category', 'writer_id');
    }

    public function posts()
    {
      return $this->hasMany('App\Entities\Post', 'writer_id');
    }

    public function comments()
    {
      return $this->hasMany('App\Entities\Comment', 'writer_id');
    }
  
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

    public function avatar()
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function followers()
    {
      return $this->hasMany(User::class);
    }

    public function followings()
    {
      return $this->hasMany(User::class);
    }
}
