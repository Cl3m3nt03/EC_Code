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


        echo.channel('retro.' + retro_id)
        .listen('RetrosColumnCreated', (e) => {
            console.log("Colonne reçue via event :", e);

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
        const retroId = document.querySelector('input[name="retro_id"]').value;
    
        const formData = new FormData();
        formData.append('name', name);
    
        fetch(`/retros/${retroId}/columns`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
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
                console.error('Erreur lors de la création de la colonne (data) :', data);
            }
        })
        .catch(err => console.error('Erreur AJAX :', err));
    });
    
});
