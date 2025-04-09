<?php

namespace App\Http\Requests\GencestorAnimal;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnimalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    
    
    public function rules(): array
    {
        return [
            'chip_number' => 'nullable|string|max:255',
            'studbook_number' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'kennel' => 'nullable|string|max:255',
            'kennel_name_first' => 'nullable|boolean',
            'awards' => 'nullable|array',
            'awards.gen1' => 'nullable|string',
            'awards.gen2' => 'nullable|string',
            'awards.gen3' => 'nullable|string',
            'awards.gen4' => 'nullable|string',
            'note' => 'nullable|string|max:2047',
            'birthdate' => 'nullable|date',
            'breed' => 'nullable|string|max:255',
            'sex' => 'nullable|in:male,female,unknown',
            'size' => 'nullable|string|max:255',
            'hair_type' => 'nullable|string|max:255',
            'hair_color' => 'nullable|string|max:255',
            'mother_id' => 'nullable|exists:animals,id',
            'father_id' => 'nullable|exists:animals,id',
        ];
    }
}
