<?php

namespace App\Http\Controllers;

/**
 * Class BackendController.
 */
class BackendController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	return view('backend');
    }
}
