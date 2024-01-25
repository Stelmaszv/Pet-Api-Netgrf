<?php

use Tests\TestCase;
use App\Models\Pets;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PetTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_pets()
    {
        $response = $this->getJson('/api/pets');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['data' => []]);
    }

    public function test_can_create_a_pet_with_validation_errors()
    {
        $petData = Pets::factory()->state([
            'name' => '', // Invalid: Name is required
            'status' => '', // Invalid: Status is required
            'category_id' => '', // Invalid: Category ID does not exist
        ])->make()->toArray();

        $response = $this->postJson('/api/pets', $petData);

        $response->assertStatus(422);
    }

    public function test_can_delete_a_pet()
    {
        $pet = Pets::factory()->create();

        $response = $this->deleteJson("/api/pets/{$pet->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Pet deleted successfully']);
    }

    
    public function test_can_create_a_pet()
    {
        $petData = Pets::factory()->make()->toArray();

        $response = $this->postJson('/api/pets', $petData);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'name', 'status', 'category_id', 'created_at', 'updated_at']])
            ->assertJson(['data' => $petData]);
    }

    public function test_can_get_a_single_pet()
    {
        $pet = Pets::factory()->create();

        $response = $this->getJson("/api/pets/{$pet->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'name', 'status', 'category_id', 'created_at', 'updated_at']])
            ->assertJson(['data' => $pet->toArray()]);
    }

    public function test_can_update_a_pet()
    {
        $pet = Pets::factory()->create();
        $updateData = Pets::factory()->make()->toArray();

        $response = $this->putJson("/api/pets/{$pet->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'name', 'status', 'category_id', 'created_at', 'updated_at']])
            ->assertJson(['data' => $updateData]);
    }

    public function test_returns_404_for_nonexistent_pet()
    {
        $response = $this->getJson('/api/pets/999');
        $response->assertStatus(404)
            ->assertJson(['error' => 'Pet not found']);

    }
    
}
