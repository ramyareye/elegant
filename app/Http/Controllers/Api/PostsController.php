<?php

namespace App\Http\Controllers\Api;

use App\Entities\Post;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\PostTransformer;

class PostsController extends Controller
{
    use Helpers;

    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
        $this->middleware('permission:list-posts')->only('index');
        $this->middleware('permission:list-posts')->only('show');
        $this->middleware('permission:create-posts')->only('store');
        $this->middleware('permission:update-posts')->only('update');
        $this->middleware('permission:delete-posts')->only('destroy');
    }

    public function index(Request $request)
    {
        $paginator = $this->model;

        if (request()->has('sort') && request()->sort !== null) {
            list($sortCol, $sortDir) = explode('|', request()->sort);
            $paginator = $paginator->orderBy($sortCol, $sortDir);
        } else {
            $paginator = $paginator->orderBy('id', 'desc');
        }

        if ($request->exists('filter')) {
            $paginator->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('title', 'like', $value);
            });
        }

        $paginator = $paginator->paginate($request->get('per_post', config('app.pagination_limit')));
        
        if ($request->has('per_post')) {
            $paginator->appends('limit', $request->get('per_post'));
        }

        return $this->response->paginator($paginator, new PostTransformer());
    }

    public function show($id)
    {
        $post = $this->model->where('id', $id)
            ->with(['categories', 'images'])
            ->firstOrFail();

        return $this->response->item($post, new PostTransformer());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $post = $this->model->create($request->all());        

        $post->categories()->sync([$request->category]);

        return $this->response->item($post, new PostTransformer());
    }

    public function update(Request $request, $id)
    {
        $post = $this->model->where('id', $id)->firstOrFail();
        $rules = [
            'title' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'title' => 'sometimes|required'
            ];
        }
        $this->validate($request, $rules);

        $post->update(
            $request->except(
                '_token',
                'categories'
            )
        );

        $post->categories()->sync([$request->category]);

        $post->update($request->except('_token'));

        return $this->response->item($post->fresh(), new PostTransformer());
    }

    public function destroy(Request $request, $id)
    {
        $post = $this->model->where('id', $id)->firstOrFail();
        $post->delete();

        return $this->response->noContent();
    }

    public function search(Request $request)
    {
      $data = $this->model->where('title', 'LIKE', $request->get('text'))
                            ->limit(10)
                            ->get();

      return $this->response->array([ "data" => $data]);
    }

    public function uploadFile(Request $request, $id)
    {
        $post = $this->model->where('id', $id)->firstOrFail();

        $post->addMediaFromRequest('file')->toMediaCollection('images');

        return $this->response->item($post->fresh(), new PostTransformer());
    }

    public function deleteFile(Request $request, $id, $image_id)
    {
        dd(1);
        $post = $this->model->where('id', $id)->firstOrFail();

        $media = $post->getMedia('images')->where('id', $image_id)->first();
        
        $media->delete();

        return $this->response->item($post->fresh(), new PostTransformer());
    }

    public function categories(Request $request)
    {
        // $categories = $this->model
        // if ($request->has('name'))
        $post = $this->model->where('id', $id)->firstOrFail();

        $media = $post->getMedia('images')->where('id', $image_id)->first();
        
        $media->delete();

        return $this->response->item($post->fresh(), new PostTransformer());
    }

}
