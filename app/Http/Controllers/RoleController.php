<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function listar(Request $request): JsonResponse
    {
        $columns = [
            0 => 'roles.id',
            1 => 'roles.name',
        ];

        $totalData = DB::table('roles')->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        $query = DB::table('roles')
            ->select(['roles.id', 'roles.name']);

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where('roles.name', 'LIKE', "%{$search}%");
            $totalFiltered = $query->count();
        }

        $roles = $query
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];

        foreach ($roles as $role) {
            $nested = [];
            $nested['id']   = $role->id;
            $nested['nome'] = $role->name;
            $nested['status'] = '<span class="badge badge-success">Ativo</span>';
            $nested['acoes'] = "<div class='text-end'>".
                "<a href='/roles/{$role->id}' class='btn btn-sm btn-info me-1'>Visualizar</a>".
                "<a href='/roles/{$role->id}/edit' class='btn btn-sm btn-warning'>Editar</a>".
                "</div>";

            $data[] = $nested;
        }

        return response()->json([
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data,
        ]);
    }
}
