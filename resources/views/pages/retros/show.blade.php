<x-app-layout>
    <x-slot name="header">
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
            boards: [
                {
                    id: 'todo',
                    title: 'À faire',
                    item: [
                        { id: 'task-1', title: 'Tâche 1' }
                    ]
                },
                {
                    id: 'doing',
                    title: 'En cours',
                    item: []
                },
                {
                    id: 'done',
                    title: 'Fait',
                    item: []
                }
            ],
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
    
</x-app-layout>