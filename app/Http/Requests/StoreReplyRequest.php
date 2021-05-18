<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'body' => ['required']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
