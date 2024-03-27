@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-4">Eventos</h1>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4" onclick="openModal()">Agregar Evento</button>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($events as $event)
        <div class="border rounded-md p-4">
            <h2 class="text-xl font-semibold mb-2">{{ $event->name }}</h2>
            <p class="text-gray-600 mb-2">{{ $event->date }}</p>
            <p class="text-gray-600 mb-4">{{ $event->description }}</p>
            <p class="text-blue-500 font-semibold">{{ $event->tickets }} Tickets</p>
            <p class="text-blue-500 font-semibold">{{ $event->remaining_tickets }} Remaining</p>
            <p class="text-blue-500 font-semibold">Price/T {{ $event->price_per_ticket}}</p>
        </div>
        @endforeach
    </div>

    <div class="fixed inset-0 overflow-y-auto px-4 hidden" id="myModal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-md w-full">
                <form action="{{ route('event.store') }}" method="POST" class="p-4">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nombre del evento:</label>
                        <input type="text" id="name" name="name" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 font-bold mb-2">Fecha:</label>
                        <input type="date" id="date" name="date" class="w-full border rounded-md px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Descripción:</label>
                        <textarea id="description" name="description" class="w-full border rounded-md px-3 py-2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="tickets" class="block text-gray-700 font-bold mb-2">Cantidad de Tickets:</label>
                        <input type="number" id="tickets" name="tickets" class="w-full border rounded-md px-3 py-2 text-right">
                    </div>
                    <div class="mb-4">
                        <label for="price_per_ticket" class="block text-gray-700 font-bold mb-2">Precio por Ticket</label>
                        <input class="w-full border rounded-md px-3 py-2 text-right" type="number" id="price_per_ticket" name="price_per_ticket" step="0.01" min="0">
                    </div>
                    <div class="text-right">
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
</script>
@endsection