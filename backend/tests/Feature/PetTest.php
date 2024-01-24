<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pets;

class ApiPetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_pets()
    {
        $response = $this->getJson('/api/pets/all');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['data' => []]);
    }

    public function test_can_create_a_pet()
    {
        $petData = [
            'name' => 'Fluffy',
            'status' => 'aktywne',
        ];

        $response = $this->postJson('/api/pets/store', $petData);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);
    }

    public function test_can_update_a_pet()
    {
        $pet = Pets::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'status' => 'realizowane',
        ];

        $response = $this->putJson("/api/pets/update/{$pet->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_can_delete_a_pet()
    {
        $pet = Pets::factory()->create();

        $response = $this->deleteJson("/api/pets/destroy/{$pet->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Pet deleted successfully']);
    }

    public function test_can_get_a_single_pet()
    {
        $pet = Pets::factory()->create();

        $response = $this->getJson("/api/pets/show/{$pet->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_returns_404_for_nonexistent_pet()
    {
        $response = $this->getJson('/api/pets/show/999');

        $response->assertStatus(404)
            ->assertJson(['error' => 'Pet not found']);
    }
}