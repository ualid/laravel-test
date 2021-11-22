<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = User::orderBy('name');

            if ($request->filled('limit')) {

                if ($request->limit == '-1') {
                    $data = $query->get();
                } else {
                    $data = $query->paginate($request->limit);
                }
            } else {
                $data = $query->paginate(config('app.pageLimit'));
            }
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro inesperado',
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = [
                "name" => $request->name,
                "email" => $request->email,
                "email_verified_at" => $request->email_verified_at,
                "password" => bcrypt($request->password),
                "remember_token" =>  $request->remember_token
            ];
            return response()->json(User::create($data));
        } catch (\Throwable $e) {
            return response()->json([
                'title' => 'Erro inesperado',
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
