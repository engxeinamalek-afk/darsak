<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\CourseStatus;
use Illuminate\Support\Facades\Gate;
use App\Traits\MapsArabicFields;
class UpdateCourseRequest extends FormRequest
{
    use MapsArabicFields;
    public function fieldsMapping(): array
    {
        return [
            'الحالة' => 'status',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    { 
        $course = $this->route('instructor_course');

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
            'status' => ['required', 'string', Rule::enum(CourseStatus::class)]
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'يجب ادخال الحالة',
            'status.string' => 'الحالة جب ان يكون سلسلة نصية',
            'status.enum' => 'الحالة المحددة غير مدعومة. الخيارات المتاحة هي: ' . implode(', ', array_column(CourseStatus::cases(), 'value')),


        ];
    }
}
