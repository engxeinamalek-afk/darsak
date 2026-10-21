<?php

namespace App\Http\Requests;

use App\Traits\MapsArabicFields;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        if ($this->routeIs('instructor.image')) {
            return true; 
        }

        $model = $this->route('imageable'); 
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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],     
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'حقل الصورة مطلوب ولا يمكن تركه فارغاً.',
            'image.image'    => 'الملف المرفوع يجب أن يكون صورة صالحة.',
            'image.mimes'    => 'امتداد الصورة غير مدعوم، الامتدادات المسموحة هي: jpeg, png, jpg, gif.',
            'image.max'      => 'حجم الصورة كبير جداً، الحد الأقصى المسموح به هو 2 ميجابايت (2048 كيلوبايت).',
        ];
    }

}
