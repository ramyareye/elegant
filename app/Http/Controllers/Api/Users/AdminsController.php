<?php

namespace App\Http\Controllers\Api\Users;

use App\Entities\User;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\Users\AdminTransformer;

/**
 * Class AdminsController.
 *
 * @author Jose Fonseca <jose@ditecnologia.com>
 */
class AdminsController extends Controller
{
    use Helpers;

    /**
     * @var Admin
     */
    protected $model;

    /**
     * AdminsController constructor.
     *
     * @param Admin $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->admins = $model->admins();
        $this->middleware('permission:list-admins')->only('index');
        $this->middleware('permission:list-admins')->only('show');
        $this->middleware('permission:create-admins')->only('store');
        $this->middleware('permission:update-admins')->only('update');
        $this->middleware('permission:delete-admins')->only('destroy');
    }

    /**
     * Returns the Admins resource with the roles relation.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        
        $paginator = $this->admins->with('roles.permissions');

        if (request()->has('sort') && request()->sort !== null) {
            list($sortCol, $sortDir) = explode('|', request()->sort);
            $paginator = $paginator->orderBy($sortCol, $sortDir);
        } else {
            $paginator = $paginator->orderBy('id', 'desc');
        }

        if ($request->exists('filter')) {
            $paginator->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('name', 'like', $value)
                    ->orWhere('email', 'like', $value);
            });
        }

        $paginator = $paginator->paginate($request->get('per_page', config('app.pagination_limit')));
        
        if ($request->has('per_page')) {
            $paginator->appends('limit', $request->get('per_page'));
        }

        return $this->response->paginator($paginator, new AdminTransformer());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $admin = $this->model->with('roles.permissions')->byUuid($id)->firstOrFail();

        return $this->response->item($admin, new AdminTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = $this->model->create($request->except('password_confirmation'));

        $admin->syncRoles(['Admin']);

        return $this->response->item($admin, new AdminTransformer());
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function update(Request $request, $uuid)
    {
        $admin = $this->model->byUuid($uuid)->firstOrFail();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$admin->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,'.$admin->id,
            ];
        }
        $this->validate($request, $rules);
        
        $admin->update($request->except('_token', 'password'));
        
        return $this->response->item($admin->fresh(), new AdminTransformer());
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function destroy(Request $request, $uuid)
    {
        $admin = $this->model->byUuid($uuid)->firstOrFail();
        $admin->delete();

        return $this->response->noContent();
    }
}
