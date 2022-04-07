<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBlogRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => ["required", "string", "max:255"],
            "image" => ["nullable", "image"],
            "content" => ["required", "string"],
            "token" => ["required", "string"]
        ];
    }

    public function attributes()
    {
        return [
            "title" => __('forms.title'),
            "image" => __('forms.image'),
            "content" => __('forms.content'),
            "token" => "Token"
        ];
    }
}
