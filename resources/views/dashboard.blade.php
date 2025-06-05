<x-metronic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="text-gray-500">{{ __('Associados') }}</div>
                    <div class="mt-2 text-3xl">{{ $usersCount }}</div>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="text-gray-500">{{ __('Grupos de Permissão') }}</div>
                    <div class="mt-2 text-3xl">{{ $rolesCount }}</div>
                </div>
                <div class="bg-white p-6 shadow sm:rounded-lg">
                    <div class="text-gray-500">{{ __('Usuários por Grupo') }}</div>
                    <ul class="mt-2 space-y-1">
                        @foreach($usersByRole as $role)
                            <li>{{ $role->name }}: {{ $role->users_count }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-metronic-layout>
