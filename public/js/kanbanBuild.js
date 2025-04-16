

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
        boards: window.columnsFromServer || [],
        dropEl: function (el, target, source, sibling) {
            const cardId = el.dataset.eid;
            const newColumnId = target.parentElement.dataset.id;
            updateCardDatabase(cardId, newColumnId);
        },
        buttonClick: function (el, boardId) {
            Swal.fire({
                title: 'Ajouter une carte',
                input: 'text',
                inputLabel: 'Nom de la carte',
                inputPlaceholder: 'Nom de la carte...',
                showCancelButton: true,
                confirmButtonText: 'Ajouter',
                cancelButtonText: 'Annuler',
                preConfirm: () => {
                    const title = Swal.getInput().value;
                    if (!title) {
                        Swal.showValidationMessage('Veuillez entrer un nom pour la carte');
                    }
                    return title;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    createCardInDatabase(boardId, result.value);
                }
            });
        },
        itemAddOptions: {
            enabled: true,
            content: '+ Ajouter une carte',
            class: 'add-card-button',
            footer: true
        }
    });

    initKanban(retro_id);

    console.log(retro_id);
        Echo.channel('retro.' + retro_id)
        .listen('.retros-column-created', (e) => {
            console.log("Colonne reçue via event :", e);
            KanbanTest.addBoards([{
                id: String(e.column.id),
                title: e.column.name,
                class: 'info',
            }]);
            
        });
        
        Echo.channel('retro.' + retro_id)
        .listen('.retros-data-created', (e) => {
        console.log("Carte reçue :", e.data);

        KanbanTest.addElement(String(e.data.column_id), {
            id: String(e.data.id),
            title: e.data.name + ' - ' + e.data.description
        });
    });

        Echo.channel('retro.' + retro_id)
        .listen('.card-move-update', (e) => {
            console.log("📡 Carte déplacée via Pusher :", e);
        
            KanbanTest.removeElement(String(e.id));
        
            KanbanTest.addElement(String(e.column_id), {
                id: String(e.id),
                title: e.name
            });
        });
        
        
        // Gérer la création de colonne via AJAX
        document.getElementById('createColumnBtn').addEventListener('click', function () {
            Swal.fire({
                title: 'Ajouter une colonne',
                input: 'text',
                inputLabel: 'Nom de la colonne',
                inputPlaceholder: 'Entrer un nom...',
                showCancelButton: true,
                confirmButtonText: 'Créer',
                cancelButtonText: 'Annuler',
                preConfirm: (value) => {
                    if (!value) {
                        Swal.showValidationMessage('Le nom est requis');
                    }
                    return value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const name = result.value;
                    const retroId = document.getElementById('retro_id').getAttribute('data-id');
        
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
                            Swal.fire('✅ Colonne créée !', '', 'success');
                        } else {
                            Swal.fire('❌ Erreur !', 'Impossible de créer la colonne', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('❌ Erreur AJAX', '', 'error');
                    });
                }
            });
        });
        
        
        //ajax for initialization
        function initKanban(id){
            fetch(`/retros/${id}/fetch`)
                .then(response => response.json())
                .then(data => {
                    console.log("Data reçue :", data);
                    if (data && Array.isArray(data.boards)) {
                        data.boards.forEach(board => {
                          KanbanTest.addBoards([{
                            id: String(board.id),
                            title: board.name,
                            class: "info",
                            item: board.items.map(item => ({
                              id: String(item.id),
                              title: item.name
                            }))
                          }]);
                        });
                      }
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des colonnes :', error);
                });
        }

        function updateCardDatabase(cardId, columnId) {
            fetch(`/retros/data/move`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ column_id: columnId, card_id: cardId })
            })
        }

});

function createCardInDatabase(boardId, name) {
    fetch(`/retros/data`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            column_id: boardId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.card) {
            KanbanTest.addElement(String(boardId), {
                id: String(data.card.id),
                title: data.card.name
            });
        } else {
        }
    })
}