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
       // Create fake place
       $name  = "avatar.png";
       $size = 500; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $response = $this->postJson("/api/places", [
           "upload" => $upload,
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
