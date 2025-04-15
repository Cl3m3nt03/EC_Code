<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">   
        <label>
            <a href="{{ route('retro.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Retour à la liste des rétrospectives
            </a>
        </label>
        <h1 class="text-xl font-bold">{{ $retro->name }}</h1>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <p><strong>Date de création :</strong> {{ $retro->created_at->format('d/m/Y') }}</p>
            <p><strong>Promotion :</strong> {{ $retro->promotion->nom ?? 'Aucune' }}</p>
        </div>
    </div>

    <div id="kanban" class="p-6"></div>
    <div id="user_id" data-id="{{ Auth::user()->id}}"></div>
    <div id="retro_id" data-id="{{$retro->id}}"></div>



    <form id="formCreateGroup" method="POST">
        @csrf
        <input type="hidden" name="retro_id" value="{{ $retro->id }}">
        <label>Nom de la colonne</label>
        <input type="text" name="name" id="nameInput" required />
        <button type="submit">Créer une colonne</button>
    </form>

    <script src="{{ asset('js/jkanban.min.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>


        window.columnsFromServer = @json(
                $retro->columns->map(fn($col) => [
                    'id' => 'col_' . $col->id,
                    'title' => $col->name,
                    'item' => []
                ])
            );
    </script>
</x-app-layout>
