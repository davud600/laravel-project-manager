<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'text' => 'max:225|',
            'userfile' => 'max:2048|mimes:pdf,docx,xlsx,jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'text.max' => 'Message is too long!',
            'userfile.max' => 'File must not be greater than 2048 kilobytes.',
            'userfile.mimes' => 'File must be of type: pdf, docx, xlsx, jpg, png.'
        ];
    }
}
