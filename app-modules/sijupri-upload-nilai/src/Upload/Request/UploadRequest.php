<?php
namespace Src\Upload\Request;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'base64_file' => 'required|string',
        ];
    }
}
