<?php

namespace App\Http\Controllers\Api;

use App\Entities\Related;
use App\Entities\Category;
use App\Entities\Reference;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\CategoryTransformer;

use DB;

class CategoriesController extends Controller
{
    use Helpers;

    protected $model;

    public function __construct(Category $model)
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
            $categories = $this->model->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('name', 'like', $value);
            })->get();
        } else {
            if ($request->has('id')) {
                $category = $this->model->where('id', $request->id)->firstOrFail();

                $categories = $this->model->whereDescendantOf($category)
                    ->where('parent_id', $request->id)->defaultOrder()->get();
            } else {
                $categories = $this->model->whereIsRoot()->defaultOrder()->get();
            }
        }

        return $this->response->array(['data' => $categories]);
    }

    public function show($id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();        

        return $this->response->item($category, new CategoryTransformer());
    }

    public function store(Request $request)
    {        
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = $this->model->create($request->all());

        if ($request->parent_id && $request->get('parent_id') !== 0) {
            $parent = $this->model
                    ->where('id', $request->get('parent_id'))
                    ->firstOrFail();

            $parent->appendNode($category);
        }

        return $this->response->item($category, new CategoryTransformer());
    }

    public function update(Request $request, $id)
    {        
        $category = $this->model->where('id', $id)->firstOrFail();

        $rules = [
            'name' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required'
            ];
        }

        $this->validate($request, $rules);

        if ($category->parent_id !== $request->get('parent_id')) {            
            if ($request->get('parent_id') !== 0) {
                $parent = $this->model
                    ->where('id', $request->get('parent_id'))
                    ->firstOrFail();

                $parent->appendNode($category);
            } else {
                $category->saveAsRoot();                
            }            
        }

        $category->update($request->except('_token', 'parent_id', 'references', 'related'));

        $category->references()->delete();
        $category->related()->delete();

        foreach($request->references as $ref) {
            if (isset($ref['name']) && isset($ref['url'])) {
                Reference::create([
                    'name' => $ref['name'],
                    'url' => $ref['url'],
                    'referenceable_id' => $category->id,
                    'referenceable_type' => 'App\Entities\Category'
                ]);
            }
        }

        foreach($request->related as $rel) {
            if (isset($rel['type']) && isset($rel['related_id'])) {
                Related::create([
                    'type' => $rel['type'],
                    'related_id' => $rel['related_id'],
                    'relateable_id' => $category->id,
                    'relateable_type' => 'App\Entities\Category'
                ]);
            }
        }

        $category->retag($request->tags);

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }

    public function destroy(Request $request, $id)
    {
      $category = $this->model->where('id', $id)->firstOrFail();
      $category->delete();

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
      $category = $this->model->where('id', $id)->first();

      $category->up();

      return $this->response->array([ "data" => $category]);
    }

    public function down(Request $request, $id)
    {
      $category = $this->model->where('id', $id)->first();

      $category->down();

      return $this->response->array([ "data" => $category]);
    }

    public function uploadFile(Request $request, $id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();

        $category->addMediaFromRequest('file')->toMediaCollection('images');

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }

    public function deleteFile(Request $request, $id, $image_id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();

        $media = $category->getMedia('images')->where('id', $image_id)->first();
        
        $media->delete();

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }

    public function uploadCover(Request $request, $id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();

        $category->addMediaFromRequest('file')->toMediaCollection('cover');

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }

    public function deleteCover(Request $request, $id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();

        $media = $category->getMedia('cover')->first();
        
        $media->delete();

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }

    public function uploadImage(Request $request, $id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();

        $category->addMediaFromRequest('file')->toMediaCollection('image');

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }

    public function deleteImage(Request $request, $id)
    {
        $category = $this->model->where('id', $id)->firstOrFail();

        $media = $category->getMedia('image')->first();
        
        $media->delete();

        return $this->response->item($category->fresh(), new CategoryTransformer());
    }
}
