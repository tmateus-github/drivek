<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Empty body.
     *
     * @return void
     */
    public function test_empty_body()
    {
        $response = $this->post('/api/users/importer');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Invalid mime type
     */
    public function test_invalid_mime_type()
    {
        Storage::fake('avatars');

        $response = $this->json('POST', '/api/users/importer', [
            'csv' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * 200 flow
     */
    public function test_ok()
    {
        Storage::fake('uploads');

        $row1 = 'tiago_mateus@msn.com;mateus;tiago;255323840;description;2021-05-21 23:43:20';
        $row2 = 'tiago.mateus@msn.com;mateus;tiago;255323840;description;2021-05-21 23:43:20';

        $content = implode("\n", [$row1, $row2]);

        $response = $this->json('POST', '/api/users/importer', [
            'csv' => UploadedFile::fake()->createWithContent('test.csv', $content)
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
