<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HttpRequestsTest extends TestCase
{

    //Чтобы работал, необходимо устанавливать расширение GD
    // public function test_avatars_can_be_uploaded()
    // {
    //     Storage::fake('avatars');

    //     $file = UploadedFile::fake()->image('avatar.jpg');

    //     $response = $this->post('/api/v1/notebook', [
    //         'name' => 'Dima',
    //         'company' => 'NeftAndGaz',
    //         'phone' => '89153012654',
    //         'email' => 'asd@mail.ru',
    //         'birth_Date' => '07.08.2001',
    //         'image' => $file,
    //     ]);

    //     $response->dump();
    // }

    public function test_insert_record()
    {
        $response = $this->post('/api/v1/notebook', [
            'name' => 'Anton',
            'company' => 'NeftAndGaz',
            'phone' => '8930145445',
            'email' => 'samson@mail.ru',
        ]);

        $response->dump();
    }

    public function test_get_records()
    {
        $response = $this->get('/api/v1/notebook');

        $response->dump();
    }

    public function test_update_record()
    {
        $response = $this->post('/api/v1/notebook/2', [
            'name' => 'Valentin',
            'company' => 'Rosneft',
            'phone' => '8977746512',
            'email' => 'zebra@mail.ru',
            'birth_date' => '18.04.2000',
        ]);

        $response->dump();
    }

    public function test_delete_record()
    {
        $response = $this->delete('/api/v1/notebook/3');

        $response->dump();
    }
}
