<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\SaleController;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_sale_list(): void
    {
        $response = $this->get('/sales');

        $response->assertStatus(200);
    }


    public function test_store_method_creates_sale()
    {
        // Mocking request data
        $requestData = [
            'event_id' => 1,
            'qty_tickets' => 3,
            'client_name' => 'Francisco',
            'client_dni' => 'V12921696',
            'client_phone' => '+584160975875',
            'date' => '2024-03-07',
        ];

        $event = Event::factory()->create([
            'id'=>1,
            'name' => 'Prueba1',
            'description' => 'Descripción del evento',
            'tickets' => 100,
            'date' => '2024-03-28',
            'price_per_ticket' => '25.00',
            'remaining_tickets'=>100
        ]);


        Storage::fake('public');
        $file = UploadedFile::fake()->create('voucher.pdf');

        $request = new Request($requestData);
        $request->files->add(['voucher' => $file]);

        $saleController = new SaleController();

        $response = $saleController->store($request);

        
        $this->assertDatabaseHas('sales', [
            'event_id' => 1,
            'qty_tickets' => 3,
            'buyer' => 'V12921696: Francisco (+584160975875)',
            'date' => '2024-03-07',
            
        ]);

       // $response->assertRedirect(route('sales.list'));
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
