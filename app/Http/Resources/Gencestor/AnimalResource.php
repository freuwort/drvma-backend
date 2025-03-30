<?php

namespace App\Http\Resources\Gencestor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->load_family_tree == true && $this->generation < 5) {
            $mother = $this->mother;

            if ($mother) {
                $mother->load_family_tree = true;
                $mother->generation = $this->generation + 1;
            }

            $mother = AnimalResource::make($mother);



            $father = $this->father;

            if ($father) {
                $father->load_family_tree = true;
                $father->generation = $this->generation + 1;
            }

            $father = AnimalResource::make($father);
        }
        else {
            $mother = BasicAnimalResource::make($this->mother);
            $father = BasicAnimalResource::make($this->father);
        }

        return [
            'id' => $this->id,
            'legacy_id' => $this->legacy_id,
            'chip_number' => $this->chip_number,
            'studbook_number' => $this->studbook_number,
            'full_name' => $this->full_name,
            'name' => $this->name,
            'kennel' => $this->kennel,
            'kennel_name_first' => $this->kennel_name_first,
            'awards' => $this->awards,
            'note' => $this->note,
            'birthdate' => $this->birthdate,
            'breed' => $this->breed,
            'sex' => $this->sex,
            'size' => $this->size,
            'hair_type' => $this->hair_type,
            'hair_color' => $this->hair_color,
            'pedigree' => BasicPedigreeResource::make($this->pedigree),
            'mother' => $mother,
            'father' => $father,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'load_family_tree' => $this->load_family_tree ?? false,
            'generation' => $this->generation ?? 0,
        ];
    }
}
