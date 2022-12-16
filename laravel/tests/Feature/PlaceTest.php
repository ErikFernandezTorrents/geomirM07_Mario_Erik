<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Mymodel;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

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

       // Create fake place
       //$id = auth()->user()->id;
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
        // Create fake place with invalid max size
        //$id = auth()->user()->id;
        $name  = "avatar.png";
        $namePlace = "lloc";
        $size = 5000; /*KB*/
        $description = 'hola bones';
        $latitude = 'X3748300';
        $longitude = 'M0044030';
        $visibility_id = 'public';
        $author_id = '2';
        $upload = UploadedFile::fake()->image($name)->size($size);

        // Upload fake place using API web service
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
    public function test_place_read(object $place)
    {
        // Read one place
        $response = $this->getJson("/api/places/{$place->id}");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON exact values

        // $response->assertJsonPath("data.filepath",
        //     fn ($filepath) => !empty($filepath)
        // );
    }

    public function test_place_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/places/{$id}");
        $this->_test_notfound($response);
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
    protected function _test_error($response)
    {
        // Check response
        $response->assertStatus(422);
        // Check validation errors
        $response->assertInvalid(["upload"]);
        // Check JSON properties
        $response->assertJson([
            "message" => true, // any value
            "errors"  => true, // any value
        ]);       
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );
        $response->assertJsonPath("errors",
            fn ($errors) => is_array($errors)
        );
    }
    protected function _test_notfound($response)
    {
        // Check JSON response
        $response->assertStatus(404);
        // Check JSON properties
        $response->assertJson([
            "success" => false,
            "message" => true // any value
        ]);
        // Check JSON dynamic values
        $response->assertJsonPath("message",
            fn ($message) => !empty($message) && is_string($message)
        );       
    }
}
