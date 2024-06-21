<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Infrastructure\Persistence\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        dd($categories);

//        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        dd('hola');

    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Category $category)
    {
        $category->delete();

        dd('hola lo borre');
    }

}
