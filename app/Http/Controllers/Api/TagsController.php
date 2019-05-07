<?php

namespace App\Http\Controllers\Api;

use Cviebrock\EloquentTaggable\Models\Tag;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\TagTransformer;

use DB;

class TagsController extends Controller
{
    use Helpers;

    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
        $this->middleware('permission:list-categories')->only('index');
        $this->middleware('permission:list-categories')->only('show');
        $this->middleware('permission:create-categories')->only('store');
        $this->middleware('permission:update-categories')->only('update');
        $this->middleware('permission:delete-categories')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->exists('filter') && $request->filter !== null) {
            // $paginator->where(function($q) use($request) {
            //     $value = "%{$request->filter}%";
            //     $q->where('title', 'like', $value);
            // });
            $tags = $this->model->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('name', 'like', $value);
            })->get();
        } else {
            if ($request->has('id')) {
                $tag = $this->model->where('id', $request->id)->firstOrFail();

                $tags = $this->model->whereDescendantOf($tag)
                    ->where('parent_id', $request->id)->defaultOrder()->get();
            } else {
                $tags = $this->model->whereIsRoot()->defaultOrder()->get();
            }
        }

        return $this->response->array(['data' => $tags]);
    }

    public function show($id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        return $this->response->item($tag, new TagTransformer());
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'name' => 'required'
        ]);

        $tag = $this->model->create($request->all());

        if ($request->parent_id && $request->get('parent_id') !== 0) {
            $parent = $this->model
                    ->where('id', $request->get('parent_id'))
                    ->firstOrFail();

            $parent->appendNode($tag);
        }

        return $this->response->item($tag, new TagTransformer());
    }

    public function update(Request $request, $id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();
        $rules = [
            'name' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required'
            ];
        }

        $this->validate($request, $rules);

        if ($tag->parent_id !== $request->get('parent_id')) {            
            if ($request->get('parent_id') !== 0) {
                $parent = $this->model
                    ->where('id', $request->get('parent_id'))
                    ->firstOrFail();

                $parent->appendNode($tag);
            } else {
                $tag->saveAsRoot();                
            }            
        }

        $tag->update($request->except('_token', 'parent_id', 'references'));

        $tag->references()->delete();

        foreach($request->references as $ref) {
            if (isset($ref['name']) && isset($ref['url'])) {
                Reference::create([
                    'name' => $ref['name'],
                    'url' => $ref['url'],
                    'referenceable_id' => $tag->id,
                    'referenceable_type' => 'App\Entities\Category'
                ]);
            }
        }

        return $this->response->item($tag->fresh(), new TagTransformer());
    }

    public function destroy(Request $request, $id)
    {
      $tag = $this->model->where('id', $id)->firstOrFail();
      $tag->delete();

      return $this->response->noContent();
    }

    public function search(Request $request)
    {
      $data = $this->model->where('name', 'LIKE', '%' . $request->get('keyword') . '%')
                            ->limit(10)
                            ->get();

      return $this->response->array([ "data" => $data ]);
    }

    public function up(Request $request, $id)
    {
      $tag = $this->model->where('id', $id)->first();

      $tag->up();

      return $this->response->array([ "data" => $tag]);
    }

    public function down(Request $request, $id)
    {
      $tag = $this->model->where('id', $id)->first();

      $tag->down();

      return $this->response->array([ "data" => $tag]);
    }

    public function uploadFile(Request $request, $id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        $tag->addMediaFromRequest('file')->toMediaCollection('images');

        return $this->response->item($tag->fresh(), new TagTransformer());
    }

    public function deleteFile(Request $request, $id, $image_id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        $media = $tag->getMedia('images')->where('id', $image_id)->first();
        
        $media->delete();

        return $this->response->item($tag->fresh(), new TagTransformer());
    }

    public function uploadCover(Request $request, $id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        $tag->addMediaFromRequest('file')->toMediaCollection('cover');

        return $this->response->item($tag->fresh(), new TagTransformer());
    }

    public function deleteCover(Request $request, $id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        $media = $tag->getMedia('cover')->first();
        
        $media->delete();

        return $this->response->item($tag->fresh(), new TagTransformer());
    }

    public function uploadImage(Request $request, $id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        $tag->addMediaFromRequest('file')->toMediaCollection('image');

        return $this->response->item($tag->fresh(), new TagTransformer());
    }

    public function deleteImage(Request $request, $id)
    {
        $tag = $this->model->where('id', $id)->firstOrFail();

        $media = $tag->getMedia('image')->first();
        
        $media->delete();

        return $this->response->item($tag->fresh(), new TagTransformer());
    }
}
