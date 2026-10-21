<?php

namespace App\Http\Requests;

use App\Traits\MapsArabicFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;

class AttachTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $model = $this->route('taggable'); 
        return Gate::allows('manage', $model);
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tags'   => ['required', 'array', 'min:1'], 
    
            'tags.*' => ['integer', 'exists:tags,id'], 
        ];
    }

    public function messages(): array
    {
        return [
            'tags.required' => 'يجب اختيار وسم واحد على الأقل.',
            'tags.array'    => 'صيغة الوسوم المرسلة غير صحيحة.',
            'tags.min'      => 'يجب اختيار وسم واحد على الأقل.',
            
            'tags.*.integer' => 'مُعرّف الوسم يجب أن يكون رقماً صحيحاً.',
            'tags.*.exists'  => 'بعض الوسوم المختارة غير موجودة في النظام أو تم حذفها.',
        ];
    }


}
