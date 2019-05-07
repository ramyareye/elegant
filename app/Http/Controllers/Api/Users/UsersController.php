<?php

namespace App\Http\Controllers\Api\Users;

use App\Entities\User;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\Users\UserTransformer;

/**
 * Class UsersController.
 *
 * @author Jose Fonseca <jose@ditecnologia.com>
 */
class UsersController extends Controller
{
    use Helpers;

    /**
     * @var User
     */
    protected $model;

    /**
     * UsersController constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->users = $model->users();
        $this->middleware('permission:list-users')->only('index');
        $this->middleware('permission:list-users')->only('show');
        $this->middleware('permission:create-users')->only('store');
        $this->middleware('permission:update-users')->only('update');
        $this->middleware('permission:delete-users')->only('destroy');
    }

    /**
     * Returns the Users resource with the roles relation.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $paginator = $this->users->with('roles.permissions');

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

        return $this->response->paginator($paginator, new UserTransformer());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->users->with('roles.permissions')->byUuid($id)->firstOrFail();

        return $this->response->item($user, new UserTransformer());
    }

    public function showByEmail($email)
    {
        $user = $this->model->where('email', $email)
                    ->with('roles.permissions')->firstOrFail();
                    
        return $this->response->item($user, new UserTransformer());
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

        $user = $this->users->create($request->all());

        if ($request->has('roles')) {
            $user->syncRoles($request['roles']);
        }

        return $this->response->created(url('api/users/'.$user->uuid));
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function update(Request $request, $uuid)
    {
        $user = $this->users->byUuid($uuid)->firstOrFail();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            ];
        }
        $this->validate($request, $rules);
        // Except password as we don't want to let the users change a password from this endpoint
        $user->update($request->except('_token', 'password'));
        if ($request->has('roles')) {
            $user->syncRoles($request['roles']);
        }

        return $this->response->item($user->fresh(), new UserTransformer());
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function destroy(Request $request, $uuid)
    {
        $user = $this->users->byUuid($uuid)->firstOrFail();
        $user->delete();

        return $this->response->noContent();
    }

    public function search(Request $request)
    {
      $keyword = '%' . $request->keyword . '%';

      $users = $this->users->where('name', 'LIKE', $keyword)
                            ->orWhere('family', 'LIKE', $keyword)
                            ->orWhere('email', 'LIKE', $keyword)
                            ->limit(10)
                            ->get();

      return $this->response->collection($users, new UserTransformer());
    }
}
