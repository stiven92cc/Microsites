<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Domain\Roles\StoreRolesAction;
use App\Domain\Roles\UpdateRolesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRolRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
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
        return $storeAction->execute($request->validated());
    }


    public function edit(string $id): Response
    {
        $roles = Role::find($id);
        return Inertia::render('Roles/Edit', compact('roles'));
    }


    public function update(UpdateRoleRequest $request, string $id, UpdateRolesAction $updateAction): RedirectResponse
    {

        return $updateAction->execute($id, $request->validated());

    }


    public function destroy(Role $roles): RedirectResponse
    {
        $roles->delete();
        return redirect()->route('roles.index');
    }
}
