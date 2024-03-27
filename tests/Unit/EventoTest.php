<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_list(): void
    {
        $response = $this->get('/event');

        $response->assertStatus(200);
    }


    public function test_create_event_successfuly(): void
    {
        $data = [
            'name' => 'Prueba1',
            'description' => 'Descripción del evento',
            'tickets' => 100,
            'date' => '2024-03-28',
            'price_per_ticket' => '25.00',
            //'ticketsTotal' => 100
        ];
        $response = $this->post('/event', $data);

        //$response->assertStatus(200);
        $response->assertRedirect('/event');

        $this->assertDatabaseHas('events', [
            'name' => 'Prueba1',
            'description' => 'Descripción del evento',
            'tickets' => 100,
            'date' => '2024-03-28',
        ]);
    }

    public function test_create_event_validation_fields(): void
    {

        $data = [
            'description' => 'Descripción del evento',
            'tickets' => 100,
            'date' => '2024-03-28',
            //'ticketsTotal' => 100
        ];
        $response = $this->post('/event', $data);

        $response->assertStatus(302);
    }
}
