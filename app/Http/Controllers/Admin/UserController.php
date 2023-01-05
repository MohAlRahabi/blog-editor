<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * return users view
     * @return Application|Factory|View|JsonResponse
     */
    public function index()
    {
        return view('dashboard.users.index');
    }

    /**
     * return data of all users
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function data(Request $request)
    {
        $items = User::query()->select('users.*');
        return DataTables::eloquent($items)
            ->addColumn('action', function ($item) {
                return '<a class="edit btn btn-xs btn-dark" style="color:#fff"><i class="fas fa-pen"></i> Edit</a>
                        <a class="delete btn btn-xs btn-danger" style="color:#fff"><i class="fas fa-trash"></i> Delete</a>';
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in database.
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return response()->json(['status'=>201,'message'=>"Created Successfully"],201);
    }

    /**
     * Update the specified resource in database.
     * @param  UpdateUserRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        return response()->json(['status'=>200,'message'=>"Updated Successfully"],200);
    }

    /**
     * Update the specified resource in database.
     * @param int $id
     * @return void
     */
    public function show($id)
    {

    }

    /**
     * Remove the specified resource from database.
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->username = $model->username . now()->toString();
        $model->save();
        $model->delete();
        return response()->json(['status'=>200,'message' => 'Successfully Deleted!'],200);
    }
}
