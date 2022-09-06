<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|unique:projects',
            'customer' => 'required',
            'description' => 'nullable|max:225',
            'estimated_time' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.max' => 'Title too long!',
            'title.unique' => 'Project with that title already exists!',
            'description.max' => 'Description is too long!',
            'customer.required' => 'Customer is required!'
        ];
    }
}
