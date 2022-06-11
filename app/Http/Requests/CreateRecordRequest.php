<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'records' => 'required|array|min:1',
            'records.*.status' => 'required|int',
            'records.*.time' => 'required|string',
            'records.*.title' => 'nullable|string',
        ];
    }

    public function messages()
    {
      return [
        'records.required' => 'Необходимо добавить минимум одну запись',
      ];
    }
}
