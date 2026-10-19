<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Traits\MapsArabicFields;
class StoreTaskRequest extends FormRequest
{    
    use MapsArabicFields;
    public function fieldsMapping(): array
    {
        return [
            'الاسم' => 'name',
            'نص التاسك' => 'body'
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $lesson= $this->route('lesson');

        return Gate::allows('manage', $lesson);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'body' =>  'required|string|max:10000'          
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'حقل الاسم مطلوب ولا يمكن تركه فارغاً.',
            'name.string'   => 'يجب أن يكون الاسم نصاً صحيحاً.',
            'name.max'      => 'يجب ألا يتجاوز الاسم 255 حرفاً.',
            
            'body.required' => 'حقل المحتوى مطلوب ولا يمكن تركه فارغاً.',
            'body.string'   => 'يجب أن يكون المحتوى نصاً صحيحاً.',
            'body.max'      => 'تجاوز المحتوى الحد المسموح',
        ];
    }
}
