<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequestUpdate;
use App\Repositories\Contracts\UserRepositoryContract;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $search = $request->get("s") ?? "";
        $perPage = 5;
        $fieldToSearch = "name";

        try {
            if ($user->tokenCan("server:list")) {
                if (!$users = $this->repository->paginate($perPage, $fieldToSearch, $search)) {
                    throw new Exception($users);
                }
                return response()->json(compact("users"));
            }
            throw new Exception("Não autorizado");
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json(compact("message"), self::STATUS_CODE_ERROR);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        try {
            if ($user->tokenCan("server:list")) {
                if (!$show = $this->repository->findOrFail($id)) {
                    throw new Exception($show);
                }
            }
            return response()->json(compact("show"));
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json(compact("message"), self::STATUS_CODE_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequestUpdate $request, $id)
    {
        $user = $request->user();

        try {
            if ($user->tokenCan("server:update") && $user->id == $id) {
                if ($data = $request->getData($user)) {
                    if (!$updated = $this->repository->update($data, $id)) {
                        throw new Exception($updated);
                    }
                    return response()->json(compact("updated"), self::STATUS_CODE_UPDATE);
                } else {
                    throw new Exception($data);
                }
            } else {
                throw new Exception("Inválido");
            }
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            return response()->json(compact("error"), self::STATUS_CODE_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        try {
            if ($user->tokenCan("server:delete") && $user->id == $id) {
                if (!$deleted = $this->repository->destroy($id)) {
                    throw new Exception($deleted);
                }
                return response()->json(compact("deleted"), self::STATUS_CODE_SUCCESS);
            }
            throw new Exception("Inválido");
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
