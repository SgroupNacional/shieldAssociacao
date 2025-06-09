@extends('template.app')

@section('css')
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('corpo')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
        {{ __('Grupos de Usuários') }}
    </h2>

    <div class="card card-flush">
        <div class="card-header pt-10">
            <div class="d-flex flex-wrap w-100 justify-content-between align-items-center">
                <div class="d-flex align-items-center mb-2">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" id="pesquisa" class="form-control form-control-solid w-250px ps-13"
                           placeholder="Pesquisar" />
                </div>

                <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">
                    <i class="ki-outline ki-plus fs-2"></i> Novo Grupo
                </a>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="roles">
                <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var tabela = $('#roles').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('roles.listar') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nome', name: 'nome' },
                    { data: 'status', name: 'status' },
                    { data: 'acoes', name: 'acoes', orderable: false, searchable: false }
                ],
                language: {
                    url: '/metronic/assets/js/json/datatablePTBR.json'
                }
            });

            $("#pesquisa").on('keyup', function () {
                tabela.search(this.value).draw();
            });
        });
    </script>
@endsection
