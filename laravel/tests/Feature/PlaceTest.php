<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class PlaceTest extends TestCase
{
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
    public function test_file_create() : object
    {
        // Create test user (BD store later)
        $name = "test_" . time();
        self::$testUser = new User([
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ]);

       // Create fake place
       $id = auth()->user()->id;
       $name  = "avatar.png";
       $namePlace = "lloc";
       $size = 500; /*KB*/
       $description = 'hola bones';
       $latitude = 'X3748300';
       $longitude = 'M0044030';
       $visibility_id = 'public';
       $upload = UploadedFile::fake()->image($name)->size($size);

       // Upload fake file using API web service
       $response = $this->postJson("/api/places", [
           "upload" => $upload,
           "name" => $namePlace,
           "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $id,
       ]);
       // Check OK response
       $this->_test_ok($response, 201);
       // Check validation errors
       $response->assertValid(["upload"]);
       // Check JSON exact values
       $response->assertJsonPath("data.filesize", $size*1024);
       // Check JSON dynamic values
       $response->assertJsonPath("data.id",
           fn ($id) => !empty($id)
       );
       $response->assertJsonPath("data.filepath",
           fn ($filepath) => str_contains($filepath, $name)
        );
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
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->postJson("/api/places", [
            "upload" => $upload,
            "name" => $namePlace,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $id,
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
