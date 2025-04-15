let user_id;
let retro_id;
let KanbanTest;

document.addEventListener('DOMContentLoaded', function () {
    // Récupérer les IDs

    const retroElement = document.getElementById('retro_id');
    if (retroElement) {
        retro_id = retroElement.getAttribute('data-id');
    } else {
        console.error('L\'élément avec l\'ID "retro_id" est introuvable.');
    }


    
    // Initialiser jKanban avec les colonnes existantes
    KanbanTest = new jKanban({
        element: '#kanban',
        gutter: '15px',
        widthBoard: '300px',
        boards: window.columnsFromServer || []
    });

    console.log(retro_id);
        Echo.channel('retro.' + retro_id)
        .listen('.retros-column-created', (e) => {
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
                document.getElementById('nameInput').value = '';
            } else {
                console.error('Erreur lors de la création de la colonne (data) :', data);
            }
        })
        .catch(err => console.error('Erreur AJAX :', err));
    });
    
});
