<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AuthRequestRegister extends FormRequest
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
            'password' => 'required|min:8|max:8',
            'confirmPassword' => 'required_with:password|same:password|min:8|max:8'
        ];
    }

    public function getUserData()
    {
        $data = $this->except(['_token', 'confirmPassword', 'isAdmin']);

        if (array_key_exists("password", $data) && $data["password"]) {
            $data["password"] = Hash::make($data["password"]);
        } else if (array_key_exists("password", $data) && empty($data["password"])) {
            unset($data["password"]);
        }
        return $data;
    }
}
