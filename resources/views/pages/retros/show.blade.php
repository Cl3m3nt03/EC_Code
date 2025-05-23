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




    <div class="flex justify-center my-4">
        <button class="btn btn-outline btn-info flex items-center gap-2" id="createColumnBtn">
            <span>Créer une carte</span>
            <i class="ki-outline ki-plus-squared"></i>
        </button>
    </div>

    <!-- Insert link and script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/jkanban.css') }}">
    <script src="{{ asset('js/jkanban.min.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
    <script src="{{ asset('js/kanbanBuild.js') }}"></script>
    <link href="{{ asset('./css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/jkanban.min.css') }}">

</x-app-layout>