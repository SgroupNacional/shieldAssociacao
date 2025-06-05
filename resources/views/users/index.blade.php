<x-metronic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table id="users-table" class="min-w-full divide-y divide-gray-200 w-full">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>{{ __('Email') }}</th>
                            <th>Grupo</th>
                            <th>Criado em</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {
                $('#users-table').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: '{{ route('users.data') }}',
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role', orderable: false, searchable: false },
                        { data: 'created_at', name: 'created_at' }
                    ]
                });
            });
        </script>
    @endpush
</x-metronic-layout>
