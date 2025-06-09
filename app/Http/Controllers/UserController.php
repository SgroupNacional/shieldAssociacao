<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller{
    public function index(): View{
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create(): View{
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse{
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View{
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse{
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index');
    }

    public function destroy(User $user): RedirectResponse{
        $user->status = false;
        $user->delete();

        return redirect()->route('users.index');
    }

    public function toggleStatus(User $user): JsonResponse
    {
        $user->status = !$user->status;
        $user->save();

        return response()->json(['status' => $user->status]);
    }

    public function listar(Request $request){
        $columns = [
            0 => 'users.id',
            1 => 'users.name',
            2 => 'role_name',
            3 => 'users.email',
            4 => 'users.status',
        ];

        $totalData = DB::table('users')
            ->where('users.status', 1)
            ->whereNull('users.deleted_at')
            ->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $query = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.status',
                'roles.name as role_name',
            ])
            ->where('users.status', 1)
            ->whereNull('users.deleted_at');

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.email', 'LIKE', "%{$search}%")
                    ->orWhere('roles.name', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $associados = $query
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];

        foreach ($associados as $item) {
            $nested = [];
            $nested['id']       = $item->id;
            $nested['nome']     = $item->name;
            $nested['email']    = $item->email;
            $nested['role']     = "<span class='badge badge-light'>{$item->role_name}</span>";
            $checked = $item->status ? 'checked' : '';
            $nested['status'] = "<label class='form-check form-switch'>"
                ."<input type='checkbox' class='form-check-input toggle-status' data-id='{$item->id}' {$checked}>"
                ."</label>";

            $token = csrf_token();
            $nested['acoes']    = "
            <div class='text-end'>
                <a href='/users/{$item->id}' class='btn btn-sm btn-info me-1'>Visualizar</a>
                <a href='/users/{$item->id}/edit' class='btn btn-sm btn-warning me-1'>Editar</a>
                <form action='/users/{$item->id}' method='POST' class='d-inline' onsubmit=\"return confirm('Tem certeza que deseja excluir este usuário?');\">
                    <input type='hidden' name='_token' value='{$token}'>
                    <input type='hidden' name='_method' value='DELETE'>
                    <button type='submit' class='btn btn-sm btn-danger'>Excluir</button>
                </form>
            </div>";

            $data[] = $nested;
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ]);
    }
}
