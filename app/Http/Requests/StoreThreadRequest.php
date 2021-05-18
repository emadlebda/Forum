<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThreadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required'],
            'body' => ['required'],
            'channel_id' => ['required', 'exists:channels,id'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
