<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'national_id'=>'unique:users,national_id,'. $this->id, 
            'email'=>'unique:users,email,'. $this->id,
            'password'=>'min:6',
            'creator' => 'exists:users,id',
            'avatar_image' => 'mimes:jpeg,jpg',
            ];
    }
}
