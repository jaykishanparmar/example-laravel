<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\FailedValidation;

class AddTaskRequest extends FormRequest
{
    use FailedValidation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "subject" => "required|string",
            "attachment" => "sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ];
    }
}
