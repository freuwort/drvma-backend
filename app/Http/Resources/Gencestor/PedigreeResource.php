<?php

namespace App\Http\Resources\Gencestor;

use App\Http\Resources\Address\BasicAddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedigreeResource extends JsonResource
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
            'title' => $this->title,
            'kennel' => $this->kennel,
            'address' => BasicAddressResource::make($this->address),
            'animals' => AnimalResource::collection($this->animals),
            'animals_count' => $this->animals_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
