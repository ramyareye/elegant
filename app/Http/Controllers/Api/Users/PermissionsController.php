<?php

namespace App\Http\Controllers\Api\Users;

use App\Entities\Permission;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Transformers\Api\Users\PermissionTransformer;

/**
 * Class PermissionsController.
 */
class PermissionsController extends Controller
{
    use Helpers;

    /**
     * @var
     */
    protected $model;

    /**
     * PermissionsController constructor.
     *
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List permissions')->only('index');
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        $paginator = $this->model->paginate(500);
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new PermissionTransformer());
    }
}
