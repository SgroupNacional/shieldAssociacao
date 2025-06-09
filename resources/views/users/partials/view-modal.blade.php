<div class="modal-header">
    <h5 class="modal-title">Visualizar Usuário</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="mb-3">
        <input class="form-control" type="text" value="{{ $user->name }}" disabled placeholder="Nome" />
    </div>
    <div class="mb-3">
        <input class="form-control" type="email" value="{{ $user->email }}" disabled placeholder="E-mail" />
    </div>
    <div class="mb-3">
        <input class="form-control" type="text" value="{{ optional($user->role)->name }}" disabled placeholder="Grupo" />
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
</div>
