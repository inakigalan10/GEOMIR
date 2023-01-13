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
 
    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();
    
        // Create test user (BD store later)
        $name = "test_" . time();
        self::$testUser = new User([
            "name"      => "{$name}",
            "email"     => "{$name}@mailinator.com",
            "password"  => "12345678"
        ]);
    }

    public function test_place_list()
    {
        // List all places using API web service
        $response = $this->getJson("/api/place");
        // Check OK response
        $this->_test_ok($response);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );

        self::$testUser->save();
    }
 
    public function test_place_create() : object
    {
        $user = self::$testUser;
        Sanctum::actingAs(
            $user,
            ['*'] // grant all abilities to the token
        );
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $description = "description";
        $latitude = 1.14;
        $longitude = 0.43;
        $visibility_id = 1;
        $category_id = 2;
        $author_id = 2;

        // Upload fake place using API web service
        $response = $this->postJson("/api/place", [
            "name"=>$name,
            "upload" => $upload,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "category_id"=>$category_id,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id,
        ]);
        

        // Check OK response
        $this->_test_ok($response, 201);

        // Check validation errors
        $response->assertValid([
            "name",
            "upload",
            "description",
            "latitude",
            "longitude",
            "visibility_id",
            "category_id",
            "author_id",
        ]);

        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );

        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }
    
    public function test_place_create_error()
    {
        // Create fake place with invalid characters
        $name  = "avatar.png";
        $size = 5000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $description = 1;
        $latitude = 'error';
        $longitude = 'error';
        $visibility_id = 'error';
        $author_id = 'error';
        $category_id = 2;

        // Upload fake place using API web service
        $response = $this->postJson("/api/place", [
            "name"=>$name,
            "upload" => $upload,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id,
            "category_id"=>$category_id

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
        $response = $this->getJson("/api/place/{$place->id}");
        // Check OK response
        $this->_test_ok($response);
    }
    
    public function test_place_read_notfound()
    {
        $id = "not_exists";
        $response = $this->getJson("/api/place/{$id}");
        $this->_test_notfound($response);
    }
    
    /**
        * @depends test_place_create
        */
    public function test_place_update(object $place)
    {
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $description = "description";
        $latitude = 1.43;
        $longitude = 0.21;
        $visibility_id = 1;
        $author_id = 2;
        $category_id=2;
        // Upload fake place using API web service
        $response = $this->putJson("/api/place/{$place->id}", [
            "name"=>$name,
            "upload" => $upload,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id,
            "category_id"=>$category_id
        ]);
        

        // Check OK response
        $this->_test_ok($response, 201);

        // Check validation errors
        $response->assertValid([
            "name",
            "upload",
            "description",
            "latitude",
            "longitude",
            "visibility_id",
            "author_id",
            "category_id"
        ]);

        // Check JSON dynamic values
        $response->assertJsonPath("data.id",
            fn ($id) => !empty($id)
        );

        // Read, update and delete dependency!!!
        $json = $response->getData();
        return $json->data;
    }
    
    /**
        * @depends test_place_create
        */
    public function test_place_update_error(object $place)
    {
        // Create fake file with invalid max size
        $name  = "photo.jpg";
        $size = 3000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $description = "description";
        $latitude = 1.43;
        $longitude = 0.21;
        $visibility_id = 1;
        $author_id = 2;
        $category_id=2;


        // Upload fake place using API web service
        $response = $this->putJson("/api/place/{$place->id}", [
            "name"=>$name,
            "upload" => $upload,
            "description" => $description,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "visibility_id" => $visibility_id,
            "author_id" => $author_id,
            "category_id" => $category_id,
        ]);

        // Upload fake file using API web service
        $response = $this->putJson("/api/place/{$place->id}", [
            "upload" => $upload,
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }
    
    public function test_place_update_notfound()
    {
        $id = "not_exists";
        $response = $this->putJson("/api/place/{$id}", []);
        $this->_test_notfound($response);
    }


         /**
     * @depends test_place_create
     */
    public function test_place_favorite(object $place)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->postJson("/api/places/{$place->id}/favorite");
        // Check OK response
        $this->_test_ok($response);
        
    }

    /**
     * @depends test_place_create
     */
    public function test_place_favorite_error(object $place)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->postJson("/api/places/{$place->id}/favorite");
        // Check ERROR response
        $response->assertStatus(500);
        
    }
   /**
     * @depends test_place_create
     */
    public function test_place_unfavorite(object $place)
    {
        Sanctum::actingAs(self::$testUser);
        // Read one file
        $response = $this->deleteJson("/api/places/{$place->id}/favorite");
        // Check OK response
        $this->_test_ok($response);
        
    }

    /**
     * @depends test_place_create
     */
    public function test_place_unfavorite_error(object $place)
    {
        Sanctum::actingAs(self::$testUser);
        $response = $this->deleteJson("/api/places/{$place->id}/favorite");
        // Check ERROR response
        $response->assertStatus(500);
        
    }
    
    /**
        * @depends test_place_create
        */
    public function test_place_delete(object $place)
    {
        // Delete one file using API web service
        $response = $this->deleteJson("/api/place/{$place->id}");
        // Check OK response
        $this->_test_ok($response);
    }
    
    public function test_place_delete_notfound()
    {
        $id = "not_exists";
        $response = $this->deleteJson("/api/place/{$id}");
        $this->_test_notfound($response);

    }
    /**
        * @depends test_place_create
        */
    
    
    protected function _test_ok($response, $status = 200)
    {
        // Check JSON response
        $response->assertStatus($status);
        // Check JSON properties
        $response->assertJson([
            "success" => true,
        ]);
        // Check JSON dynamic values
        $response->assertJsonPath("data",
            fn ($data) => is_array($data)
        );
    }
    
    /**
        * @depends test_place_create
        */

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