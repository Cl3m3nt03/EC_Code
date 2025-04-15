let user_id;
let retro_id;
let KanbanTest;

document.addEventListener('DOMContentLoaded', function () {
    // Récupérer les IDs
    const data_user = document.getElementById('user_id');
    user_id = data_user?.getAttribute('data-id');

    const data_retro = document.getElementById('retro_id');
    retro_id = data_retro?.value || data_retro?.getAttribute('data-id');

    // Initialiser jKanban avec les colonnes existantes
    KanbanTest = new jKanban({
        element: '#kanban',
        gutter: '15px',
        widthBoard: '300px',
        boards: window.columnsFromServer || []
    });


    window.Echo.channel(`retro.${retro_id}`)
        .listen('.retros-column-created', (e) => {
            console.log("Colonne reçue via Pusher :", e);

            KanbanTest.addBoards([{
                id: `col_${e.column.id}`,
                title: e.column.name,
                item: []
            }]);
        });

    // Gérer la création de colonne via AJAX
    document.getElementById('formCreateGroup').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('nameInput').value;

        fetch(`/retros/${retro_id}/columns`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.column) {
                KanbanTest.addBoards([{
                    id: `col_${data.column.id}`,
                    title: data.column.name,
                    item: []
                }]);
                document.getElementById('nameInput').value = '';
            } else {
                console.error('Erreur lors de la création de la colonne :', data);
            }
        })
        .catch(err => console.error('Erreur AJAX :', err));
    });
});
