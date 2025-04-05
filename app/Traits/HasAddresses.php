<?php

namespace App\Traits;

use App\Models\Address;

trait HasAddresses
{
    public function updateAddress(string $selector, array|null $address): bool
    {
        $id = $this->{$selector};

        // Delete address if null
        if ($address === null) {
            Address::destroy($id);
            return true;
        }

        // Update or create address...
        $address = Address::updateOrCreate(['id' => $id], $address);

        // ...and assign it to model
        $this->{$selector} = $address->id;
        $this->save();

        return true;
    }
}