<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class PlaceTest extends TestCase
{
    public static User $testUser;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_place_list()
    {
       // List all files using API web service
       $response = $this->getJson("/api/places");
       // Check OK response
       $this->_test_ok($response);
       // Check JSON dynamic values
       $response->assertJsonPath("data",
           fn ($data) => is_array($data)
       );
    }
    public function test_place_create() : object
    {
        // Create test user (BD store later)
        $name = "test_" . time();
        self::$testUser = new User([
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ]);

        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );

       // Create fake place
       $id = auth()->user()->id;
       $name  = "avatar.png";
       $namePlace = "lloc";
       $size = 500; /*KB*/
       $description = 'hola bones';
       $latitude = 'X3748300';
       $longitude = 'M0044030';
       $visibility_id = '1';
       $author_id = '2';
       $upload = UploadedFile::fake()->image($name)->size($size);

       // Upload fake file using API web service
       $response = $this->postJson("/api/places", [
           "upload" => $upload,
           "name" => $namePlace,
           "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id
       ]);
       // Check OK response
       $this->_test_ok($response, 201);
       // Check validation errors
       $response->assertValid(["upload"]);
       $response->assertValid(["name"]);
       $response->assertValid(["description"]);
       $response->assertValid(["longitude"]);
       $response->assertValid(["latitude"]);
       $response->assertValid(["visibility_id"]);
       $response->assertValid(["author_id"]);
       
        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }
    public function test_place_create_error()
    {
        // Create fake file with invalid max size
        $id = auth()->user()->id;
        $name  = "avatar.png";
        $namePlace = "lloc";
        $size = 5000; /*KB*/
        $description = 'hola bones';
        $latitude = 'X3748300';
        $longitude = 'M0044030';
        $visibility_id = 'public';
        $author_id = '2';
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->postJson("/api/places", [
            "upload" => $upload,
            "name" => $namePlace,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }
    protected function _test_ok($response, $status = 200)
    {
        // Check JSON response
        $response->assertStatus($status);
        // Check JSON properties
        $response->assertJson([
            "success" => true,
            "data"    => true // any value
        ]);
    }
}
