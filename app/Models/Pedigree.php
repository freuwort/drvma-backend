<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedigree extends Model
{
    protected $fillable = [
        'kennel',
        'title',
    ];



    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function femaleAnimalsCount()
    {
        return $this->animals->where('sex', 'female')->count();
    }

    public function maleAnimalsCount()
    {
        return $this->animals->where('sex', 'male')->count();
    }



    public function getAnimalsCountAttribute()
    {
        return $this->animals()->count();
    }

    public function getNamespaceAttribute()
    {
        return $this->kennel . '/' . $this->title;
    }
}
