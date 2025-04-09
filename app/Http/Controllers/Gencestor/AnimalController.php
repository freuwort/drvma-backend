<?php

namespace App\Http\Controllers\Gencestor;

use App\Http\Controllers\Controller;
use App\Http\Requests\GencestorAnimal\CreateAnimalRequest;
use App\Http\Requests\GencestorAnimal\UpdateAnimalRequest;
use App\Http\Resources\Gencestor\AnimalResource;
use App\Models\Animal;
use App\Rules\Address;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Animal::class);

        // Base query
        $query = Animal::with(['mother', 'father']);

        // Search
        if ($request->filter_search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                    ->orWhereFuzzy('name', $request->search)
                    ->orWhereFuzzy('kennel', $request->search)
                    ->orWhereFuzzy('breed', $request->search)
                    ->orWhereFuzzy('chip_number', $request->search)
                    ->orWhereFuzzy('studbook_number', $request->search);
            });
        }

        // Filter
        if ($request->filter_exclude) {
            $query->whereNotIn('id', $request->filter_exclude);
        }

        if ($request->sex) {
            $query->where('sex', $request->sex)->orWhere('sex', 'unknown');
        }

        // Sort
        $field = $request->sort_field ?? 'created_at';
        $order = $request->sort_order ?? 'desc';

        $query->orderBy($field, $order);

        // Return collection + pagination
        return AnimalResource::collection($query->paginate($request->size ?? 20))
        ->additional(['keys' => $query->pluck('id')->toArray()]);
    }

    
    
    public function show(Animal $animal)
    {
        $this->authorize('view', $animal);

        return AnimalResource::make($animal);
    }

    
    
    public function store(CreateAnimalRequest $request)
    {
        $this->authorize('create', Animal::class);

        $animal = Animal::create($request->validated());

        return AnimalResource::make($animal);
    }



    // public function import(ImportPedigreesRequest $request)
    // {
    //     $this->authorize('import', [Animal::class, $request->items]);

    //     foreach ($request->items as $item)
    //     {
    //         $animal = Animal::create($item);
    //     }
    // }

    
    
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $this->authorize('update', $animal);

        $animal->update($request->validated());

        return AnimalResource::make($animal->fresh());
    }

    
    
    public function destroy(Animal $animal)
    {
        $this->authorize('delete', $animal);

        $animal->delete();
    }

    
    
    public function destroyMany(Request $request)
    {
        $request->validate(['ids.*' => ['required', 'integer', 'exists:animals,id']]);
        
        $animals = Animal::whereIn('id', $request->ids);

        $this->authorize('deleteMany', [Animal::class, $animals->get()]);

        $animals->delete();
    }
}
