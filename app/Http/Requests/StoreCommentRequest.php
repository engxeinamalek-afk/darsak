<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Traits\MapsArabicFields;
class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $model = $this->route('commentable'); 

        return Gate::allows('access', $model);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'max:1000']
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'يجب ادخال التعليق',
            'body.string' => 'التعليق يجب ان يكون سلسلة نصية',
            'body.max' => 'التعليق لا يجب ان يتجاوز 1000 حرف'

        ];
    }
}
