<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_posts_list()
    {
        // List all posts using API web service
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
        // Create fake post
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $latitude=1.2;
        $longitude=0.48;
        $visibility_id=2;
        $description="Hola";

        // Upload fake file using API web service
        $response = $this->postJson("/api/files", [
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

    public function test_posts_create_error()
    {
        // Create fake post with invalid max size
        $name  = "avatar.png";
        $size = 5000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake post using API web service
        $response = $this->postJson("/api/files", [
            "upload" => $upload,
        ]);
        // Check ERROR response
        $this->_test_error($response);
    }
}


