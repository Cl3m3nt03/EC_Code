<x-app-layout>

<script src="{{ asset('js/groups.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Retrospectives') }}
            </span>
        </h1>
    </x-slot>
    <div class="card mb-10">
        <div class="card-header">
            <h3 class="card-title">
                Création de Groupes
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text">
                Créez des groupes de rétrospectives pour organiser vos sessions de manière efficace. Vous pouvez créer un groupe pour chaque équipe ou projet, et y ajouter des membres.
            </p>
        </div>
        <div class="card-footer justify-center">
            <button class="btn btn-success" data-modal-toggle="#modal_1_1">
                <i class="ki-outline ki-plus-squared">
                </i>
                Créer un groupe
            </button>
        </div>
    </div>
    <div class="modal" data-modal="true" id="modal_1_1">
        <div class="modal-content max-w-[600px] top-[20%]">
            <div class="modal-header">
                <h3 class="modal-title">Création de rétrospectives</h3>
                <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                    <i class="ki-outline ki-cross">
                    </i>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" id="formCreateGroup" action="{{ route('retros.create') }}">
                @csrf
                <label class="label">Nom du groupe</label>
                <input class="input" placeholder="Text input" type="text" name="name" required/>
                <label class="label">Sélectionnez Promotion</label>
                <select class="select" name="promotion_id" required>
                    @foreach (\App\Models\Promotion::all() as $promotion)
                    <option value="{{ $promotion->id }}">{{ $promotion->nom }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary mt-4">Créer la rétrospectives</button>
            </form>
            </div>
        </div>
    </div>
@include('pages.retros.DataTable')

</x-app-layout>
