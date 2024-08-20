<?php

namespace App\Repositories;

use App\Models\Guest;

class GuestRepository
{
    public function all()
    {
        return Guest::all();
    }

    public function findById($id)
    {
        return Guest::findOrFail($id);
    }

    public function create(array $data)
    {
        return Guest::create($data);
    }

    public function update(Guest $guest, array $data)
    {
        $guest->update($data);

        return $guest;
    }

    public function delete(Guest $guest)
    {
        $guest->delete();
    }
}
