@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-4">Ventas de Tickets</h1>

    <div class="mb-4">
        <label for="selectEvent" class="block text-gray-700 font-bold mb-2">Filtrar por Evento:</label>
        <select id="selectEvent" class="w-full border rounded-md px-3 py-2">
            <option value="">Todos los Eventos</option>
            @foreach ($events as $event)
            <option value="{{ $event->id }}">{{ $event->name }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4" onclick="openModal()">Agregar Venta</button>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-center">Evento</th>
                    <th class="px-4 py-2 text-center">Cantidad</th>
                    <th class="px-4 py-2 text-center">Total</th>
                    <th class="px-4 py-2 text-center">Cliente</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr class="salesRow" data-event="{{ $sale->event->id }}">
                    <td class="border px-4 py-2 text-center">{{ $sale->event->name }}</td>
                    <td class="border px-4 py-2 text-center">{{ $sale->qty_tickets }}</td>
                    <td class="border px-4 py-2 text-center">{{ $sale->total }}</td>
                    <td class="border px-4 py-2 text-center">{{ $sale->buyer }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="fixed inset-0 overflow-y-auto px-4 hidden" id="myModal">
        <div class="flex justify-center">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-4xl w-full max-h-screen">
                <form action="{{ route('sale.store') }}" method="POST" class="p-4" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="event_id" class="block text-gray-700 font-bold mb-2">Evento:</label>
                            <select id="event_id" name="event_id" class="w-full border rounded-md px-3 py-2">
                                @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="qty_tickets" class="block text-gray-700 font-bold mb-2">Cantidad de Tickets:</label>
                            <input type="number" id="qty_tickets" name="qty_tickets" class="w-full border rounded-md px-3 py-2" v-model="cantidad" @change="actualizarTotal">
                        </div>
                        <div class="mb-4">
                            <label for="total" class="block text-gray-700 font-bold mb-2">Total:</label>
                            <input type="text" id="total" name="total" class="w-full border rounded-md px-3 py-2" :value="total" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="client_name" class="block text-gray-700 font-bold mb-2">Cliente:</label>
                            <input type="text" id="client_name" name="client_name" class="w-full border rounded-md px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label for="client_dni" class="block text-gray-700 font-bold mb-2">Dni:</label>
                            <input type="text" id="client_dni" name="client_dni" class="w-full border rounded-md px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label for="client_phone" class="block text-gray-700 font-bold mb-2">Teléfono:</label>
                            <input type="text" id="client_phone" name="client_phone" class="w-full border rounded-md px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 font-bold mb-2">Fecha:</label>
                            <input type="date" id="date" name="date" class="w-full border rounded-md px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label for="voucher" class="block text-gray-700 font-bold mb-2">Foto del Pago:</label>
                            <input type="file" id="voucher" name="voucher" class="w-full border rounded-md px-3 py-2">
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar</button>
                        <button class="text-gray-600 px-4 py-2 rounded-md" onclick="closeModal(); return false;">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




</div>

<script>
    function openModal() {
        document.getElementById('myModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('myModal').classList.add('hidden');
    }

    const selectEvent = document.getElementById('selectEvent');
    const salesRows = document.querySelectorAll('.salesRow');
    selectEvent.addEventListener('change', function() {
        const selectedEventId = this.value;
        salesRows.forEach(row => {
            if (selectedEventId === '' || row.getAttribute('data-event') === selectedEventId) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection