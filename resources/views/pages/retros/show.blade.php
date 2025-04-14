<x-app-layout>
    <x-slot name="header">
        <label>
            <a href="{{ route('retro.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Retour à la liste des rétrospectives
            </a>
        <h1 class="text-xl font-bold">{{ $retro->name }}</h1>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <p><strong>Date de création :</strong> {{ $retro->created_at->format('d/m/Y') }}</p>
            <p><strong>Promotion :</strong> {{ $retro->promotion->nom ?? 'Aucune' }}</p>
        </div>
    </div>

        <!-- jKanban CSS -->
        <link rel="stylesheet" href="{{ asset('css/jkanban.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/jkanban@1.0.4/dist/jkanban.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/jkanban@1.0.4/dist/jkanban.min.js"></script>
    
    <!-- jKanban HTML Container -->
    <div id="kanban" class="p-6"></div>

    <!-- Scripts jKanban -->
    <script src="{{ asset('js/jkanban.js') }}"></script>

    <!-- Laravel Echo + Pusher -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>
        // Initialiser le Kanban
        var Kanban = new jKanban({
            element: '#kanban',
            boards: @json($retro->columns->map(function($col) {
                return [
                    'id' => 'column_' . $col->id,
                    'title' => $col->name,
                    'item' => []
                ];
            })->toArray()),

            dragendEl: function (el, source) {
                let taskId = el.dataset.eid; // ID de la tâche
                let newColumn = el.parentElement.dataset.id;

                // Appel AJAX pour mettre à jour en BDD
                fetch('/api/tasks/' + taskId + '/move', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ column: newColumn })
                });
            }
        });

        // Écoute Pusher avec Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") }}',
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true
        });

        // Quand une tâche est déplacée par quelqu’un d’autre
        Echo.channel('kanban')
            .listen('TaskMoved', (e) => {
                console.log('Reçu via Pusher', e);
                Kanban.removeElement(e.task.id);
                Kanban.addElement(e.task.column, {
                    id: e.task.id,
                    title: e.task.title
                });
            });
    </script>

<div>
<form method="POST" id="formCreateGroup" action="{{ route('retros.columns.create', ['retro' => $retro->id]) }}">
    @csrf
    <input type="hidden" name="retro_id" value="{{ $retro->id }}">
    <label class="label">Nom de la colonne</label>
    <input class="input" placeholder="Text input" type="text" name="name" required/> <!-- Utilisation de 'name' -->
    <button class="btn btn-primary" data-modal-toggle="#modal_1_1">
        <i class="ki-outline ki-plus-squared"></i>
        crée une colonne
    </button>
</form>
<label>crée une tache</label>
<form method="POST" id="formCreateTask" action="{{ route('retros.data.create') }}">
    @csrf
    <label class="label">Sélectionnez une colonne</label>
    <select class="select" name="column_id" id="columnSelect" required>
        @foreach ($retro->columns as $column)
            <option value="{{ $column->id }}">{{ $column->name }}</option>
        @endforeach
    </select>
    <label class="label">Nom de la tâche</label>
    <input class="input" placeholder="Nom de la tâche" type="text" name="name" required/>
    <label class="label">Description</label>
    <input class="input" placeholder="Description" type="text" name="description" required/>
    <button class="btn btn-primary" type="submit" id="createTaskButton">
        <i class="ki-outline ki-plus-squared"></i>
        Créer une tâche
    </button>
</form>

</div>
    
</x-app-layout>