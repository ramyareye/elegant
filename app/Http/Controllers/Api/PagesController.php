<?php

namespace App\Http\Controllers\Api;

use App\Entities\Page;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\PageTransformer;

class PagesController extends Controller
{
    use Helpers;

    protected $model;

    private $type = [        
        'teams',
        'default',
        'photography',
        'departments',
        'treat-fertility',
        'sterility-treatment',
        'complementary-advice',
        'men-specialized-services',
        'women-specialized-services'
    ];

    public function __construct(Page $model)
    {
        $this->model = $model;
        $this->middleware('permission:list-pages')->only('index');
        $this->middleware('permission:list-pages')->only('show');
        $this->middleware('permission:create-pages')->only('store');
        $this->middleware('permission:update-pages')->only('update');
        $this->middleware('permission:delete-pages')->only('destroy');
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

        $paginator = $paginator->paginate($request->get('per_page', config('app.pagination_limit')));
        
        if ($request->has('per_page')) {
            $paginator->appends('limit', $request->get('per_page'));
        }

        return $this->response->paginator($paginator, new PageTransformer());
    }

    public function parents()
    {
        $parents = $this->model
            ->with('parent')
            ->select('id', 'title', 'parent_id', 'created_at')->get();

        return $this->response->collection($parents, new PageTransformer());
    }

    public function show($id)
    {
        $page = $this->model->where('id', $id)
            ->with(['images', 'parent'])
            ->firstOrFail();

        return $this->response->item($page, new PageTransformer());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'required'
        ]);

        $page = $this->model->create($request->all());

        return $this->response->item($page, new PageTransformer());
    }

    public function update(Request $request, $id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();
        
        $rules = [
            'title' => 'required',
            'slug' => 'required'
        ];

        if ($request->method() == 'PATCH') {
            $rules = [
                'title' => 'sometimes|required',
                'slug' => 'sometimes|required'
            ];
        }
        
        $this->validate($request, $rules);

        $page->update($request->all());

        return $this->response->item($page->fresh(), new PageTransformer());
    }

    public function destroy(Request $request, $id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();
        $page->delete();

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
        $page = $this->model->where('id', $id)->firstOrFail();

        $page->addMediaFromRequest('file')->toMediaCollection('images');

        return $this->response->item($page->fresh(), new PageTransformer());
    }

    public function deleteFile(Request $request, $id, $image_id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();

        $media = $page->getMedia('images')->where('id', $image_id)->first();
        
        $media->delete();

        return $this->response->item($page->fresh(), new PageTransformer());
    }

    public function uploadCover(Request $request, $id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();

        $page->addMediaFromRequest('file')->toMediaCollection('cover');

        return $this->response->item($page->fresh(), new PageTransformer());
    }

    public function deleteCover(Request $request, $id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();

        $media = $page->getMedia('cover')->first();
        
        $media->delete();

        return $this->response->item($page->fresh(), new PageTransformer());
    }

    public function uploadImage(Request $request, $id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();

        $page->addMediaFromRequest('file')->toMediaCollection('image');

        return $this->response->item($page->fresh(), new PageTransformer());
    }

    public function deleteImage(Request $request, $id)
    {
        $page = $this->model->where('id', $id)->firstOrFail();

        $media = $page->getMedia('image')->first();
        
        $media->delete();

        return $this->response->item($page->fresh(), new PageTransformer());
    }
}
