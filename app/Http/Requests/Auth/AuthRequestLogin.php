<?php

namespace App\Http\Requests\Auth;

use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AuthRequestLogin extends FormRequest
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
            "email" => "required",
            'password' => "required"
        ];
    }

    public function authenticate()
    {
        $email = $this->input("email");
        $userRepository = app(UserRepositoryContract::class);
        $user = $userRepository->findValue("email", $email);
        if (!$user) {
            return false;
        }
        $password = Hash::check($this->input('password'), $user->password);
        if ($user && $password) {
            return $user;
        }
        return false;
    }
}
