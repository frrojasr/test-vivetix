<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_sale_list(): void
    {
        $response = $this->get('/sales');

        $response->assertStatus(200);
    }


    public function test_create_sale_successfuly(): void
    {
        $data = [
            'event_id' => 1,
            'qty_tickets' =>100,
            'client_name' => 'Francisco',
            'client_dni' => 'V12921696',
            'client_phone' => '+584160975875',
            'client_address' => 'Venezuela',
           // 'voucher' => 'required|file|mimes:jpg,pdf|max:2048', 
            'date' => '2024-03-28'
        ];
        $response = $this->post('/sales', $data);

        //$response->assertStatus(200);
        $response->assertRedirect('/sales');

        $this->assertDatabaseHas('sales', [
            'name' => 'Prueba1',
            'description' => 'Descripción del evento',
            'tickets' => 100,
            'date' => '2024-03-28',
        ]);
    }

    public function test_create_sale_validation_fields(): void
    {

        $data = [
            'event_id' => 1,
            'qty_tickets' =>100,
            'client_name' => 'Francisco',
            'client_dni' => 'V12921696',
            'client_phone' => '+584160975875',
           // 'voucher' => 'required|file|mimes:jpg,pdf|max:2048', 
            'date' => '2024-03-28'
        ];
        $response = $this->post('/sales', $data);

        $response->assertStatus(302);
    }

}
