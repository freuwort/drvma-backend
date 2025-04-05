<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'legacy_id',
        'chip_number',
        'studbook_number',
        'name',
        'kennel',
        'kennel_name_first',
        'awards',
        'note',
        'birthdate',
        'breed',
        'sex',
        'size',
        'hair_type',
        'hair_color',
        'pedigree_id',
        'mother_id',
        'father_id',
    ];

    protected $attributes = [
        'kennel_name_first' => false,
    ];

    protected $casts = [
        'kennel_name_first' => 'boolean',
        'awards' => 'array',
        'birthdate' => 'date',
    ];



    public function mother()
    {
        return $this->belongsTo(Animal::class, 'mother_id');
    }

    public function father()
    {
        return $this->belongsTo(Animal::class, 'father_id');
    }

    public function children()
    {
        return $this->hasMany(Animal::class, 'mother_id');
    }

    public function siblings()
    {
        return $this->hasMany(Animal::class, 'mother_id')->where('id', '!=', $this->id);
    }

    public function pedigree()
    {
        return $this->belongsTo(Pedigree::class);
    }



    public function getFullNameAttribute()
    {
        if ($this->kennel_name_first) {
            return $this->kennel . ' ' . $this->name;
        }

        return $this->name . ' ' . $this->kennel;
    }



    public function duplicate() 
    {
        $post = $this->replicate()->fill([
            'name' => $this->name . ' (Kopie)',
        ]);
        
        $post->push();

        return $post;
    }

    public static function assignMany(array $animal_ids, int $pedigree_id)
    {
        return static::whereIn('id', $animal_ids)->update(['pedigree_id' => $pedigree_id]);
    }
}
