<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return Auth::user()->can("store Teams");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:255"],
            "image" => ["nullable", "image"],
            "description" => ["required", "string"],
            "users" => ["required", "array"],
        ];
    }

    public function attributes()
    {
        return [
            "name" => __('forms.name'),
            "image" => __('forms.imahe'),
            "description" => __('forms.description'),
            "users" => __('forms.users'),
        ];
    }
}
