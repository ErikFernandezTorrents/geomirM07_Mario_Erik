<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public static User $testUser;

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

    public function test_post_list()
   {
       // List all post using API web service
       $response = $this->getJson("/api/posts");
       // Check OK response
       $this->_test_ok($response);
       // Check JSON dynamic values
       $response->assertJsonPath("data",
           fn ($data) => is_array($data)
       );
   }

    public function test_post_create() : object
    {

        Sanctum::actingAs(
            self::$testUser,
            ['*'] // grant all abilities to the token
        );

       // Create fake post
       $name  = "avatar.png";
       $body= "Post";
       $size = 500; /*KB*/
       $latitude = 'X3748300';
       $longitude = 'M0044030';
       $visibility_id = '1';
       $author_id = '2';
       $upload = UploadedFile::fake()->image($name)->size($size);

       // Upload fake file using API web service
       $response = $this->postJson("/api/posts", [
           "upload" => $upload,
           "body" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id
       ]);
       // Check OK response
       $this->_test_ok($response, 201);
       // Check validation errors
       $response->assertValid(["upload"]);
       $response->assertValid(["body"]);
       $response->assertValid(["longitude"]);
       $response->assertValid(["latitude"]);
       $response->assertValid(["visibility_id"]);
       $response->assertValid(["author_id"]);
       
        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }
    public function test_post_create_error()
    {
        // Create fake file with invalid max size
        $name  = "avatar.png";
        $body = "Post";
        $size = 5000; /*KB*/
        $latitude = 'X3748300';
        $longitude = 'M0044030';
        $visibility_id = 'public';
        $author_id = '2';
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $response = $this->postJson("/api/posts", [
            "upload" => $upload,
            "name" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }

    /**
    * @depends test_post_create
    */

    public function test_post_read(object $post)
    {
        // Read one post
        $response = $this->getJson("/api/posts/{$post->id}");
        // Check OK response
        $this->_test_ok($response);
    }

    public function test_post_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/posts/{$id}");
        $this->_test_notfound($response);
    }
    
    /**
    * @depends test_post_create
    */
    public function test_post_update(object $post)
    {
        // Create fake post
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $body = 'hola bones';
        $latitude = 'X3748300';
        $longitude = 'M0044030';
        $visibility_id = 2;
        $author_id = 2;
        $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake post using API web service
       $response = $this->putJson("/api/posts/{$post->id}", [
            "upload" => $upload,
            "body" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "author_id" => $author_id,
            "visibility_id" => $visibility_id,
       ]);
       // Check OK response
       $this->_test_ok($response);
       // Check validation errors
       $response->assertValid(["upload"]);
       $response->assertValid(["body"]);
       $response->assertValid(["longitude"]);
       $response->assertValid(["latitude"]);
       $response->assertValid(["visibility_id"]);
       $response->assertValid(["author_id"]);
   }
 
   /**
    * @depends test_post_create
    */
   public function test_post_update_error(object $post)
   {
       // Create fake file with invalid max size
       // Create fake post
       $name  = "avatar.png";
       $size = 5000; /*KB*/
       $body = 'hola bones';
       $latitude = 'X3748300';
       $longitude = 'M0044030';
       $visibility_id = 'public';
       $author_id = '2';
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $response = $this->putJson("/api/posts/{$post->id}", [
            "upload" => $upload,
            "body" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
       ]);
       // Check ERROR response
       $this->_test_error($response);
   }
 
   public function test_post_update_notfound()
   {
       $id = "not_exists";
       $response = $this->putJson("/api/posts/{$id}", []);
       $this->_test_notfound($response);
   }

    /**
    * @depends test_post_create
    */
    public function test_post_delete(object $post)
    {
        // Delete one file using API web service
        $response = $this->deleteJson("/api/posts/{$post->id}");
        // Check OK response
        $this->_test_ok($response);
    }
  
    public function test_post_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/posts/{$id}");
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

    public function test_post_last()
    {
        // Eliminem l'usuari al darrer test
        self::$testUser->delete();
        // Comprovem que s'ha eliminat
        $this->assertDatabaseMissing('users', [
            'email' => self::$testUser->email,
        ]);
    } 

}
