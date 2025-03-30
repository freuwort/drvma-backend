<?php

namespace App\Http\Controllers\Gencestor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pedigree\CreatePedigreeRequest;
use App\Http\Requests\Pedigree\ImportPedigreesRequest;
use App\Http\Requests\Pedigree\UpdatePedigreeRequest;
use App\Http\Resources\Gencestor\PedigreeResource;
use App\Models\Pedigree;
use Illuminate\Http\Request;

class PedigreeController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Pedigree::class);

        // Base query
        $query = Pedigree::with(['animals']);

        // Search
        if ($request->filter_search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                    ->orWhereFuzzy('kennel', $request->filter_search)
                    ->orWhereFuzzy('title', $request->filter_search);
            });
        }

        // Filter
        if ($request->filter_exclude) {
            $query->whereNotIn('id', $request->filter_exclude);
        }

        // Sort
        $field = $request->sort_field ?? 'created_at';
        $order = $request->sort_order ?? 'desc';

        $query->orderBy($field, $order);

        // Return collection + pagination
        return PedigreeResource::collection($query->paginate($request->size ?? 20))
        ->additional(['keys' => $query->pluck('id')->toArray()]);
    }

    
    
    public function show(Pedigree $pedigree)
    {
        $this->authorize('view', $pedigree);

        return PedigreeResource::make($pedigree);
    }

    
    
    public function store(Request $request)
    {
        $this->authorize('create', Pedigree::class);

        $request->validate([
            'kennel' => ['required', 'string'],
            'title' => ['required', 'string'],
        ]);

        $pedigree = Pedigree::create($request->only(['kennel', 'title']));

        return PedigreeResource::make($pedigree);
    }



    // public function import(ImportPedigreesRequest $request)
    // {
    //     $this->authorize('import', [Pedigree::class, $request->items]);

    //     foreach ($request->items as $item)
    //     {
    //         $pedigree = Pedigree::create($item);
    //     }
    // }

    
    
    // public function update(UpdatePedigreeRequest $request, Pedigree $pedigree)
    // {
    //     $this->authorize('update', $pedigree);

    //     $pedigree->update($request->validated());

    //     return PedigreeResource::make($pedigree->fresh());
    // }

    
    
    public function destroy(Pedigree $pedigree)
    {
        $this->authorize('delete', $pedigree);

        $pedigree->delete();
    }

    
    
    public function destroyMany(Request $request)
    {
        $request->validate(['ids.*' => ['required', 'integer', 'exists:pedigrees,id']]);
        
        $pedigrees = Pedigree::whereIn('id', $request->ids);

        $this->authorize('deleteMany', [Pedigree::class, $pedigrees->get()]);

        $pedigrees->delete();
    }
}
