<?php

namespace App\Services;

use App\DTOs\GuestDTO;
use App\Repositories\GuestRepository;

class GuestService
{
    private $guestRepository;

    public function __construct(GuestRepository $guestRepository)
    {
        $this->guestRepository = $guestRepository;
    }

    public function getAllGuests()
    {
        return $this->guestRepository->all();
    }

    public function getGuestById($id)
    {
        return $this->guestRepository->findById($id);
    }

    public function createGuest(GuestDTO $guestDTO)
    {
        $guestData = [
            'first_name' => $guestDTO->firstName,
            'last_name' => $guestDTO->lastName,
            'email' => $guestDTO->email,
            'phone' => $guestDTO->phone,
            'country' => $guestDTO->country ?? $this->determineCountry($guestDTO->phone),
        ];

        return $this->guestRepository->create($guestData);
    }

    public function updateGuest($id, GuestDTO $guestDTO)
    {
        $guest = $this->getGuestById($id);

        $guestData = [
            'first_name' => $guestDTO->firstName,
            'last_name' => $guestDTO->lastName,
            'email' => $guestDTO->email,
            'phone' => $guestDTO->phone,
            'country' => $guestDTO->country ?? $this->determineCountry($guestDTO->phone),
        ];

        return $this->guestRepository->update($guest, $guestData);
    }

    public function deleteGuest($id)
    {
        $guest = $this->getGuestById($id);
        $this->guestRepository->delete($guest);
    }

    private function determineCountry($phone)
    {
        if (strpos($phone, '+7') === 0) {
            return 'Россия';
        }

        return 'Неизвестно';
    }
}
