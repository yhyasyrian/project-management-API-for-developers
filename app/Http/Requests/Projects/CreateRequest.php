<?php

namespace App\Http\Requests\Projects;

use Illuminate\Validation\Rule;
use App\Enums\ProjectStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'description' => ['required','string'],
            'client_id' => ['required','exists:users,id'],
            'content' => ['required','string'],
            'price' => ['required','numeric','min:0'],
            'domain' => ['nullable','string','max:255'],
            'route_check' => ['nullable','string','max:255'],
            'status' => ['required',Rule::enum(ProjectStatusEnum::class)],
            'can_check' => ['nullable','boolean'],
            'start_at' => ['required','date'],
            'end_at' => ['nullable','date','after:start_at'],
        ];
    }
}
