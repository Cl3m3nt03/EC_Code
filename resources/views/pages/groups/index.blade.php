<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-5 text-sm font-normal">
            <span class="text-gray-700 gap-5">
                {{ __('Groupes') }}
            </span>
            <span>Total des groupes : {{ \App\Models\Groupe::count() }}<i class="ki-outline ki-users"></i></span>
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
                    <label class="label">Sélectionnez Promotion</label>
                    <select class="select" name="promotion_id" required>
                        @foreach (\App\Models\Promotion::all() as $promotion)
                        <option value="{{ $promotion->id }}">{{ $promotion->nom }}</option>
                        @endforeach
                    </select>
                    <label class="label">Sélectionnez Le nombre d'élèves</label>
                    <div>
                        <input type="number" id="tentacles" name="tentacles" min="1" max="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Entre 1 et 4" required />
                    </div>
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
            <p class="text-sm text-gray-700">Promotion : {{ $groupe->promotion->nom }}</p>
            <p class="text-sm text-gray-700 font-semibold mt-2">Membres :</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                @foreach ($groupe->users as $user)
                <div class="bg-gray-100 rounded-lg p-2 text-sm text-gray-800 shadow-sm">
                    {{ $user->first_name }} {{ $user->last_name }}
                </div>
                @endforeach
            </div>
            <p class="text-xs text-gray-500 mt-4">Créé le {{ $groupe->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-footer mt-4 flex justify-center gap-4">
            <form method="POST" action="{{ route('groupes.destroy', $groupe->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline btn-danger">Supprimer</button>
            </form>

            <button class="btn btn-outline btn-warning" data-modal-toggle="#modal_{{ $groupe->id }}">Modifier</button>
        </div>

        <!-- Modal -->
        <div class="modal" data-modal="true" id="modal_{{ $groupe->id }}">
            <div class="modal-content max-w-[600px] top-[20%]">
                <div class="modal-header">
                    <h3 class="modal-title">Modifier Groupe</h3>
                    <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                        <i class="ki-outline ki-cross"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('groupes.update', $groupe->id) }}">
                        @csrf
                        @method('PUT')

                        <label class="label">Nom du Groupe</label>
                        <input class="input" name="nom" value="{{ $groupe->nom }}" placeholder="Nom du groupe" type="text" required />
                        <button type="submit" class="btn btn-primary mt-4">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
</x-app-layout>