@extends('template.app')

@section('css')
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('corpo')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
        {{ __('Usuários') }}
    </h2>

    <div class="card card-flush">
        <div class="card-header pt-10">
            <div class="d-flex flex-wrap w-100 justify-content-between align-items-center">

                <!-- Campo de pesquisa à esquerda -->
                <div class="d-flex align-items-center mb-2">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" id="pesquisa" class="form-control form-control-solid w-250px ps-13"
                           placeholder="Pesquisar" />
                </div>

                <!-- Botão à direita -->
                <button type="button" id="btnCreateUser" class="btn btn-primary mb-2">
                    <i class="ki-outline ki-plus fs-2"></i> Novo Usuário
                </button>
            </div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="usuarios">
                <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>#</th>
                    <th>Nome</th>
                    <th>Grupo/Permissões</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                {{-- Populado via DataTable --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modalViewUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="modalCreateUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var tabela = $('#usuarios').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users.listar') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nome', name: 'nome' },
                    { data: 'role', name: 'role' },
                    { data: 'email', name: 'email' },
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

            $(document).on('change', '.toggle-status', function () {
                let checkbox = $(this);
                let id = checkbox.data('id');
                let url = '/users/' + id + '/status';

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    title: 'Confirmação',
                    message: 'Deseja alterar o status?',
                    position: 'center',
                    buttons: [
                        ['<button>Sim</button>', function (instance, toast) {
                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: {_token: '{{ csrf_token() }}'},
                                success: function () {
                                    iziToast.success({title: 'Sucesso', message: 'Status atualizado'});
                                    tabela.ajax.reload(null, false);
                                },
                                error: function () {
                                    iziToast.error({title: 'Erro', message: 'Não foi possível atualizar'});
                                    tabela.ajax.reload(null, false);
                                }
                            });
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }, true],
                        ['<button>Não</button>', function (instance, toast) {
                            checkbox.prop('checked', !checkbox.prop('checked'));
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }]
                    ]
                });
            });

            $(document).on('click', '.delete-user', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                let url = '/users/' + id;

                iziToast.question({
                    timeout: false,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    title: 'Confirmação',
                    message: 'Tem certeza que deseja excluir este usuário?',
                    position: 'center',
                    buttons: [
                        ['<button>Sim</button>', function (instance, toast) {
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                data: {_token: '{{ csrf_token() }}'},
                                success: function () {
                                    iziToast.success({title: 'Sucesso', message: 'Usuário excluído'});
                                    tabela.ajax.reload(null, false);
                                },
                                error: function () {
                                    iziToast.error({title: 'Erro', message: 'Não foi possível excluir'});
                                    tabela.ajax.reload(null, false);
                                }
                            });
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }, true],
                        ['<button>Não</button>', function (instance, toast) {
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }]
                    ]
            $(document).on('click', '.view-user', function () {
                const id = $(this).data('id');
                $('#modalViewUser .modal-content').load('/users/' + id + '/view-modal', function () {
                    const modal = new bootstrap.Modal(document.getElementById('modalViewUser'));
                    modal.show();
                });
            });

            $(document).on('click', '.edit-user', function () {
                const id = $(this).data('id');
                $('#modalEditUser .modal-content').load('/users/' + id + '/edit-modal', function () {
                    const modal = new bootstrap.Modal(document.getElementById('modalEditUser'));
                    modal.show();
                });
            });

            $(document).on('click', '#btnCreateUser', function () {
                $('#modalCreateUser .modal-content').load('/users/create-modal', function () {
                    const modal = new bootstrap.Modal(document.getElementById('modalCreateUser'));
                    modal.show();
                });
            });

            $(document).on('submit', '#modalEditUser form', function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function () {
                        bootstrap.Modal.getInstance(document.getElementById('modalEditUser')).hide();
                        tabela.ajax.reload(null, false);
                        iziToast.success({title: 'Sucesso', message: 'Usuário atualizado'});
                    },
                    error: function (xhr) {
                        $('#modalEditUser .modal-content').html(xhr.responseText);
                    }
                });
            });

            $(document).on('submit', '#modalCreateUser form', function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function () {
                        bootstrap.Modal.getInstance(document.getElementById('modalCreateUser')).hide();
                        tabela.ajax.reload(null, false);
                        iziToast.success({title: 'Sucesso', message: 'Usuário criado'});
                    },
                    error: function (xhr) {
                        $('#modalCreateUser .modal-content').html(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
