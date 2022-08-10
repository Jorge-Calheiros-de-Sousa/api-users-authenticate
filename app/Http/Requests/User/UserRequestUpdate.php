<?php

namespace App\Http\Requests\User;

use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequestUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'required|max:11|min:11',
            'description' => 'nullable',
            'linkedin' => 'nullable',
            'github' => 'nullable',
            'password' => 'min:8|max:8'
        ];
    }

    public function getData($user)
    {
        $password = $this->input("password");
        $data = $this->except(['_token', 'isAdmin', 'password']);
        if (Hash::check($password, $user->password)) {
            return $data;
        }
        return false;
    }
}
