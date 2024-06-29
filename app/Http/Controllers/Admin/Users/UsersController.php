<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Infrastructure\Persistence\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Users/Index', ['users' => User::all()]);
    }


    public function create(): Response
    {
        return Inertia::render('Users/Create');
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());
        return redirect()->route('users.index');
    }


    public function edit(string $id): Response
    {
        $user = User::find($id);
        return Inertia::render('Users/Edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->toArray());
        return redirect()->route('users.index');
    }


    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index');
    }

}
