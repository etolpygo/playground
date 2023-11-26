<?php

namespace App\Http\Requests;

use App\Enums\JobTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'job_code' => 'required|max:8',
            'title' => 'required|max:255',
            'location' => 'required|max:255',
            'job_type' => [
                'required',
                new Enum(JobTypeEnum::class)
            ],
            'salary' => 'nullable|max:32',
            'application_deadline' => 'nullable|date',
            'description' => 'required|max:2048',
            'requirements' => 'required|max:2048',
            'accepting_applications' => 'sometimes|boolean',
        ];
    }
}