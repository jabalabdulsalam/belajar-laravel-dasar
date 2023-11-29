<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testUpload()
    {
        $image = UploadedFile::fake()->image("jabal.png");

        $this->post('/file/upload', [
            'picture' => $image
        ])->assertSeeText("Oke jabal.png");
    }
}
