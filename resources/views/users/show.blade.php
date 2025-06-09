@extends('template.app')

@section('css')
@endsection

@section('corpo')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        <form class="form w-100">
                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">Visualizar Usuário</h1>
                            </div>
                            <div class="fv-row mb-8">
                                <input class="form-control bg-transparent" type="text" value="{{ $user->name }}" disabled placeholder="Nome" />
                            </div>
                            <div class="fv-row mb-8">
                                <input class="form-control bg-transparent" type="email" value="{{ $user->email }}" disabled placeholder="E-mail" />
                            </div>
                            <div class="fv-row mb-8">
                                <input class="form-control bg-transparent" type="text" value="{{ optional($user->role)->name }}" disabled placeholder="Grupo" />
                            </div>
                            <div class="text-center">
                                <a href="{{ route('users.index') }}" class="btn btn-light">Voltar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('{{ asset('metronic/assets/media/misc/auth-bg.png') }}')">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="/" class="mb-0 mb-lg-12">
                        <img alt="Logo" src="{{ asset('metronic/assets/media/logos/custom-1.png') }}" class="h-60px h-lg-75px" />
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection

@section('script')
@endsection
