<?php
namespace App\DTOs;

class GuestDTO
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phone;
    public ?string $country;

    public function __construct(array $data)
    {
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->country = $data['country'] ?? null;
    }
}
