<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Infrastructure\Persistence\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function index(): Response
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::all();
        return Inertia::render('Categories/Index', ['categories' => $categories]);
    }

    public function create(): Response
    {
        $this->authorize('create', Category::class);
        return Inertia::render('Categories/Create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->authorize('store', Category::class);
        Category::create($request->validated());
        return redirect()->route('categories.index');
    }

    public function edit(Category $category): Response
    {
        $this->authorize('edit', Category::class);
        return Inertia::render('Categories/Edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('update', Category::class);
        $category->update($request->toArray());
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', Category::class);
        $category->delete();
        return redirect()->route('categories.index');
    }
}
