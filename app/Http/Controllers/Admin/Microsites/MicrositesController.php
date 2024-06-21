<?php

namespace App\Http\Controllers\Admin\Microsites;

use App\Domain\Microsites\Actions\StoreMicrositeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Http\Request;

class MicrositesController extends Controller
{
    public function index()
    {


        dd('ll');


    }


    public function store(StoreMicrositeRequest $request, StoreMicrositeAction $action)
    {
        $action->execute($request);

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
        $data = $request->validated();
        $microsite = Microsite::findOrFail($id);
        $microsite->update($data);
        return redirect()->route('microsites.index')->with('success', 'Microsite actualizado exitosamente');
    }


    public function destroy(Microsite $microsite)
    {
        $microsite->delete();

        dd('Microsite borrado');
    }

}
