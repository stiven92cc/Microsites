<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Constants\Permissions;
use App\Constants\Roles;
use App\Domain\Roles\StoreRolesAction;
use App\Domain\Roles\UpdateRolesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    use AuthorizesRequests;
    public function index(): Response
    {
        return Inertia::render('Roles/Index', ['roles' => Role::all()]);
    }

    public function create(): Response
    {
        return Inertia::render('Roles/Create', ['permissions' => Permission::all()]);
    }


    public function store(StoreRolRequest $request, StoreRolesAction $storeAction): RedirectResponse
    {
        $storeAction->execute($request->validated());
        return redirect()->route('roles.index');
    }


    public function edit(string $id): Response
    {
        $role = Role::with('permissions')->find($id);
        $allPermissions = Permission::all();

        return Inertia::render('Roles/Edit', compact('role', 'allPermissions'));
    }


    public function update(UpdateRoleRequest $request, string $id, UpdateRolesAction $updateAction): RedirectResponse
    {
        $updateAction->execute($id, $request->validated());
        return redirect()->route('roles.index');
    }


    public function destroy(Role $role): RedirectResponse
    {
        if (!Auth::user()->hasPermissionTo(Permissions::ROLES_DESTROY)) {
            return redirect()->back();
        }

        if (!in_array($role->name, Roles::getAllRoles())) {
            $role->delete();
        }

        return redirect()->route('roles.index');
    }


}
