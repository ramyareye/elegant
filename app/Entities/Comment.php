<?php

namespace App\Entities;

use \App\Entities\User;
use \App\Entities\Post;
use \App\Entities\Blog;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment.
 */
class Comment extends Model
{
	protected $table = 'comments';

	protected $guarded = ['id'];

	protected $dates = ['deleted_at'];

	protected $fillable = [
    'old_id',
    'writer_id',
    'name',
    'email',
    'mobile',
    'body',
    'status',
    'reply_to',
    'published_on',
    'rejected_on',
    'deleted_at'
  ];

  public function writer()
  {
      return $this->belongsToOne(User::class, 'writer_id');
  }

  public function posts()
  {
      return $this->morphedByMany(Category::class, 'commentable');
  }

  public function blog()
  {
      return $this->morphedByMany(Tag::class, 'commentable');
  }
}
