<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => ['sometimes', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'start_datetime'   => ['sometimes', 'date', 'after:now'],
            'end_datetime'     => ['sometimes', 'date', 'after:start_datetime'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'status'           => ['sometimes', 'in:draft,published,cancelled'],
        ];
    }
}
