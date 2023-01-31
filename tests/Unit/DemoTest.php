<?php

namespace Tests\Unit;

use Tests\TestCase;

class DemoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_route() {
        $response = $this->get('api/trains-saved');
        $response->assertStatus(200);
    }

    // public function test_request() {
    //     $response = $this->post('api/save-train', [
    //         'number' => '8674',
    //         'departure_place' => 'roma',
    //         'departure_time' => '10:00',
    //         'arrival_place' => 'bari',
    //         'arrival_time' => '11:00',
    //         'delay' => 3,
    //     ]);
    //     $response->assertRedirect('api/on-the-road');
    // }

    public function test_database() {
        $this->assertDatabaseHas('trains', [
            'number' => '8902',
        ]);
    }
}
