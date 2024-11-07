<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required'],
            'sales_csv' => ['required_if:type,file', 'file','mimes:csv,xls,xlsx', 'max:10240'],
            'name' => ['required_if:type,form'],
            'amount' => ['required_if:type,form'],
            'description' => ['required_if:type,form'],
        ];
    }
}
