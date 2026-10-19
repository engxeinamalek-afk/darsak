<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UrlRule;
use App\Traits\MapsArabicFields;
use Illuminate\Support\Facades\Gate;
class StoreLessonRequest extends FormRequest
{
    use MapsArabicFields;
    public function fieldsMapping(): array
    {
        return [
            'الاسم' => 'name',
            'الرابط' => 'url'
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        $course = $this->route('course');

        return Gate::allows('manage', $course);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'url', new UrlRule],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'حقل الاسم مطلوب ولا يمكن تركه فارغاً.',
            'name.string'   => 'يجب أن يكون الاسم عبارة عن نص.',
            'name.max'      => 'يجب ألا يتجاوز الاسم 255 حرفاً.',
            
            'url.required'  => 'حقل الرابط مطلوب ولا يمكن تركه فارغاً.',
            'url.string'    => 'يجب أن يكون الرابط عبارة عن نص صحيح.',
            'url.url'       => 'صيغة الرابط غير صحيحة، يرجى كتابة رابط ويب صالح (مثل: https://example.com).',
        ];
    }
}
