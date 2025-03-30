<?php

namespace App\Http\Resources\Gencestor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicAnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'chip_number' => $this->chip_number,
            'studbook_number' => $this->studbook_number,
            'full_name' => $this->full_name,
            'breed' => $this->breed,
            'sex' => $this->sex,
            'mother_id' => $this->mother_id,
            'father_id' => $this->father_id,
        ];
    }
}
