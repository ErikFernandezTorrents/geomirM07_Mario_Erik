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
    public static array $validData = [];
    public static array $invalidData = [];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public static function setUpBeforeClass() : void
   {
       parent::setUpBeforeClass();
       // Creem usuari/a de prova
       $name = "test_" . time();
       self::$testUser = new User([
           "name"      => "{$name}",
           "email"     => "{$name}@mailinator.com",
           "password"  => "12345678"
       ]);
   }
   public function test_place_first()
    {
       // Desem l'usuari al primer test
       self::$testUser->save();
       // Comprovem que s'ha creat
       $this->assertDatabaseHas('users', [
           'email' => self::$testUser->email,
       ]);
    }

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
        $user = self::$testUser;
        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );
       // Create fake place
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

   /**
    * @depends test_place_create
    */

    public function test_place_read(object $place)
    {
        // Read one place
        $response = $this->getJson("/api/places/{$place->id}");
        // Check OK response
        $this->_test_ok($response);
    }

    public function test_place_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/places/{$id}");
        $this->_test_notfound($response);
    }
    
    /**
    * @depends test_place_create
    */
    public function test_place_update(object $place)
    {
        // Create fake place
        $name  = "avatar.png";
        $namePlace = "lloc";
        $size = 500; /*KB*/
        $description = 'hola bones';
        $latitude = 'X3748300';
        $longitude = 'M0044030';
        $visibility_id = 2;
        $author_id = 2;
        $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake place using API web service
       $response = $this->putJson("/api/places/{$place->id}", [
            "upload" => $upload,
            "name" => $namePlace,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "author_id" => $author_id,
            "visibility_id" => $visibility_id,
       ]);
       // Check OK response
       $this->_test_ok($response);
       // Check validation errors
       $response->assertValid(["upload"]);
       $response->assertValid(["name"]);
       $response->assertValid(["description"]);
       $response->assertValid(["longitude"]);
       $response->assertValid(["latitude"]);
       $response->assertValid(["visibility_id"]);
       $response->assertValid(["author_id"]);
   }
 
   /**
    * @depends test_place_create
    */
   public function test_place_update_error(object $place)
   {
       // Create fake file with invalid max size
       // Create fake place
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
       $response = $this->putJson("/api/places/{$place->id}", [
            "upload" => $upload,
            "name" => $namePlace,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
       ]);
       // Check ERROR response
       $this->_test_error($response);
   }
 
   public function test_place_update_notfound()
   {
       $id = "not_exists";
       $response = $this->putJson("/api/places/{$id}", []);
       $this->_test_notfound($response);
   }

    /**
    * @depends test_place_create
    */
    public function test_place_delete(object $place)
    {
        // Delete one file using API web service
        $response = $this->deleteJson("/api/places/{$place->id}");
        // Check OK response
        $this->_test_ok($response);
    }
    /**
    * @depends test_place_create
    */
    // public function test_place_favourite(object $place)
    // {

        // Favourite one place using API web service
        // $response = $this->getJson("/api/place/{$place->id}/favourites");
        // Check OK response
        // $this->_test_ok($response);
    // }
    /**
    * @depends test_place_create
    */
    // public function test_place_unfavourite(object $place)
    // {

        // Unfavourite one place using API web service
        // $response = $this->deleteJson("/api/unfavourites/{$place->id}");
        // Check OK response
        // $this->_test_ok($response);
    //}
  
    public function test_place_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/places/{$id}");
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
    public function test_place_last()
    {
        // Eliminem l'usuari al darrer test
        self::$testUser->delete();
        // Comprovem que s'ha eliminat
        $this->assertDatabaseMissing('users', [
            'email' => self::$testUser->email,
        ]);
    }
}
