<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequestLogin;
use App\Http\Requests\Auth\AuthRequestRegister;
use App\Repositories\Contracts\UserRepositoryContract;
use Exception;

class AuthController extends Controller
{

    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(AuthRequestRegister $request)
    {
        try {
            $data = $request->getUserData();

            if (!$created = $this->repository->create($data)) {
                throw new Exception($created);
            }
            return response()->json(compact("created"));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), self::STATUS_CODE_ERROR);
        }
    }

    /**
     * Login user.
     *
     */
    public function login(AuthRequestLogin $request)
    {
        try {
            $user = $request->authenticate();

            $permissions = ["server:update", "server:delete"];

            if ($user->isAdmin) {
                array_push($permissions, "server:list");
            }

            if (!$user) {
                throw new Exception($user);
            }

            return response()->json([
                'status' => true,
                'message' => 'Usuário logado com sucesso!',
                'token' => $user->createToken($request->input("email"), $permissions)->plainTextToken,
            ]);
        } catch (\Throwable $th) {
            return response($th->getMessage(),  self::STATUS_CODE_ERROR)->send();
        }
    }


    /**
     * LogOut User
     */
    public function logOut()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'message' => 'Success!'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), self::STATUS_CODE_ERROR);
        }
    }
}
