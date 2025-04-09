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
                <form method="POST" action="{{ route('groupes.store') }}">
                    @csrf
                    <label class="label">Nom du Groupe</label>
                    <input class="input" name="nom" placeholder="Nom du groupe" type="text" required />

                    <label class="label">Sélectionnez Promotion</label>
                    <select class="select" name="promotion" required>
                        <option value="TP A">TP A</option>
                        <option value="TP B">TP B</option>
                        <option value="TP C">TP C</option>
                    </select>

                    <button type="submit" class="btn btn-primary mt-4">Créer le Groupe</button>
                </form>
            </div>
        </div>
    </div>
    @if (session('success'))
    <div class="alert alert-success mt-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
        @foreach (\App\Models\Groupe::all() as $groupe)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-lg font-bold">{{ $groupe->nom }}</h4>
            </div>
            <div class="card-body">
                <p class="text-sm text-gray-700">Promotion : {{ $groupe->promotion }}</p>
                <p class="text-xs text-gray-500">Créé le {{ $groupe->created_at->format('d/m/Y') }}</p>
            </div>
            <form method="POST" action="{{ route('groupes.destroy', $groupe->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline btn-danger">Supprimer</button>
            </form>
            <form method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-outline btn-warning">Modifier</button>
            </form>
        </div>
        @endforeach
    </div>
</x-app-layout>