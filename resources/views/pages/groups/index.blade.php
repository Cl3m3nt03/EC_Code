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
        <button class="btn btn-success">
            <i class="ki-outline ki-plus-squared">
            </i>
            Success
            </button>
        </div>
    </div>
    
</x-app-layout>
