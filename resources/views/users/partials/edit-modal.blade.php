<div class="modal-header">
    <h5 class="modal-title">Editar Usuário</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="editUserForm" method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="mb-3">
            <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="Nome" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mb-3">
            <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="E-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-3">
            <input class="form-control" type="password" name="password" placeholder="Senha (deixe em branco para manter)" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="mb-3">
            <select name="role_id" class="form-select">
                <option value="">Selecione um grupo</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</form>
