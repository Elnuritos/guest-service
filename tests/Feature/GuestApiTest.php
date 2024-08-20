<?php

namespace Tests\Feature;

use App\Models\Guest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetAllGuests()
    {
        $response = $this->getJson('/api/v1/guests');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'country',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testCanGetEmptyGuestsList()
    {
        Guest::truncate();

        $response = $this->getJson('/api/v1/guests');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    public function testCanCreateGuest()
    {
        $data = [
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'test.test@example.com',
            'phone' => '+1234567890',
            'country' => 'RU',
        ];

        $response = $this->postJson('/api/v1/guests', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function testValidationErrorWhenCreatingGuestWithInvalidData()
    {
        $data = [
            'first_name' => '',
            'last_name' => 'no',
            'email' => 'not-an-email',
            'phone' => '',
        ];

        $response = $this->postJson('/api/v1/guests', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name', 'email', 'phone']);
    }

    public function testCannotCreateGuestWithDuplicateEmailOrPhone()
    {
        $existingGuest = Guest::factory()->create();

        $data = [
            'first_name' => 'To',
            'last_name' => 'Ta',
            'email' => $existingGuest->email,
            'phone' => $existingGuest->phone,
        ];

        $response = $this->postJson('/api/v1/guests', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'phone']);
    }

    public function testCanGetGuestById()
    {
        $guest = Guest::factory()->create();

        $response = $this->getJson("/api/v1/guests/{$guest->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'first_name' => $guest->first_name,
            'last_name' => $guest->last_name,
            'email' => $guest->email,
            'phone' => $guest->phone,
        ]);
    }

    public function testGetGuestReturns404ForNonexistentId()
    {
        $response = $this->getJson('/api/v1/guests/999');

        $response->assertStatus(404);
    }

    public function testCanUpdateGuest()
    {
        $guest = Guest::factory()->create();

        $data = [
            'first_name' => 'Updated Name',
            'last_name' => 'Updated Last Name',
            'email' => 'updated.email@example.com',
            'phone' => '+1987654321',
            'country' => 'Canada',
        ];

        $response = $this->putJson("/api/v1/guests/{$guest->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function testValidationErrorWhenUpdatingGuestWithInvalidData()
    {
        $guest = Guest::factory()->create();

        $data = [
            'first_name' => '',
            'last_name' => 'Updated Last Name',
            'email' => 'not-an-email',
            'phone' => '',
        ];

        $response = $this->putJson("/api/v1/guests/{$guest->id}", $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['first_name', 'email', 'phone']);
    }

    public function testCanDeleteGuest()
    {
        $guest = Guest::factory()->create();

        $response = $this->deleteJson("/api/v1/guests/{$guest->id}");

        $response->assertStatus(204);
    }

    public function testDeleteGuestReturns404ForNonexistentId()
    {
        $response = $this->deleteJson('/api/v1/guests/999');

        $response->assertStatus(404);
    }

    public function testGetGuestWithInvalidIdReturns404()
    {
        $response = $this->getJson('/api/v1/guests/invalid-id');

        $response->assertStatus(404);
    }
}
