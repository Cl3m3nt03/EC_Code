<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Groupes') }}
            </span>
        </h1>
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Création de Groupes
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text">
                Créez des groupes pour organiser vos utilisateurs et gérer les autorisations d'accès.
            </p>
        </div>
        <div class="card-footer justify-center">
            <button class="btn btn-success" data-modal-toggle="#modal_1_1">
                <i class="ki-outline ki-plus-squared">
                </i>
                Success
            </button>
        </div>
    </div>
    <div class="modal" data-modal="true" id="modal_1_1">
        <div class="modal-content max-w-[600px] top-[20%]">
            <div class="modal-header">
                <h3 class="modal-title">Création Groupe</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross">
                    </i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label class="label">Nom du Groupe</label>
                    <input class="input" placeholder="Text input" type="text" value="" />
                    <label class="label">Selectionnez Promotion</label>
                    <select class="select" name="select">
                        <option value="1">
                            Option 1
                        </option>
                        <option value="2">
                            Option 2
                        </option>
                        <option value="3">
                            Option 3
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary">Créer le Groupe</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>