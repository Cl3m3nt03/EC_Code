document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert2 config globale 
    const baseSwalOptions = {
        background: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#1f2937' : '#fff',
        color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#f3f4f6' : '#111827',
        customClass: {
            popup: 'rounded-xl shadow-lg',
            title: 'text-lg font-semibold',
            confirmButton: 'btn btn-danger text-white px-4 py-2 rounded-lg',
            cancelButton: 'btn btn-outline px-4 py-2 rounded-lg',
            loader: 'custom-loader'
        },
        buttonsStyling: false
    };

    // create groupe alert
    const formCreate = document.getElementById('formCreateGroup');
    if (formCreate) {
        formCreate.addEventListener('submit', function () {
            Swal.fire({
                ...baseSwalOptions,
                title: 'Création du groupe...',
                text: 'Merci de patienter pendant le traitement.',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }

    //delete groupe alert
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                ...baseSwalOptions,
                title: 'Tu es sûr ?',
                text: "Tu ne pourras pas revenir en arrière.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprime !',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    //edit groupe alert

    const editForms = document.querySelectorAll('.edit-form');

    editForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
    
            Swal.fire({
                ...baseSwalOptions,
                title: 'Tu es sûr ?',
                text: "Tu vas modifier ce groupe.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, je modifie !',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
