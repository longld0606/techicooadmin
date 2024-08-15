<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LogsDataTable;
use App\Http\Requests\StoreLogsRequest;
use App\Http\Requests\UpdateLogsRequest;
use Illuminate\Support\Facades\Auth;

class LogsController extends AdminController
{
    /**
     * Display a listing of the resource.
     */

    public function index(LogsDataTable $dataTable)
    {
        $user = Auth::user();

        if (!($user->email == 'longld0606@gmail.com' || $user->email == 'longld.8x@gmail.com')) {
            abort(404);
        } 
        $users = \App\Models\User::query()->get()->toArray();
        return $dataTable->render('admin.logs.index', ["users" => $users]);
    }
    public function show(\App\Models\Logs $log)
    {
        // 
        return view('admin.logs.item', ['isAction' => 'show', 'item' => $log]);
    }
}
