<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Infrastructure\Persistence\Models\Microsite;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    use AuthorizesRequests;
    public function index(): Response
    {
        $this->authorize('viewAny', User::class);
        return Inertia::render('Users/Index', ['users' => User::all()]);
    }


    public function create(): Response
    {
        $this->authorize('create', User::class);
        return Inertia::render('Users/Create', ['roles' => Role::select('name')->get()]);
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('store', User::class);
        User::create($request->validated());
        return redirect()->route('users.index');
    }


    public function edit(string $id): Response
    {
        $this->authorize('edit', User::class);
        $user = User::find($id);
        return Inertia::render('Users/Edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', User::class);
        $user->update($request->toArray());
        return redirect()->route('users.index');
    }


    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', User::class);
        $user->delete();
        return redirect()->route('users.index');
    }

}
