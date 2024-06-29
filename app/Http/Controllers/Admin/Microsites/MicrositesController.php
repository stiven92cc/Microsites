<?php

namespace App\Http\Controllers\Admin\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use App\Domain\Microsites\Actions\StoreMicrositeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MicrositesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Microsites/Index', ['microsites' => Microsite::all()]);
    }

    public function create(): Response
    {
        return Inertia::render(
            'Microsites/Create',
            [
                'currencies' => CurrencyTypes::getTypes(),
                'types' => MicrositeTypes::getTypes(),
                'categories' => Category::all()
                    ->select('id', 'name')
                    ->pluck('name', 'id')
            ]
        );
    }

    public function store(StoreMicrositeRequest $request, StoreMicrositeAction $action): RedirectResponse
    {
        $action->execute($request);

        Cache::forget('guest.microsites');

        Log::info('Nuevo micrositio con el nombre ' . request('name').' creado por:' . auth()->user()->email);

        return redirect()->route('microsites.index');
    }

    public function show(Microsite $microsite): Response
    {
        return Inertia::render('Microsites/Show', [
            'microsite' => $microsite,
            'currencies' => CurrencyTypes::getTypes(),
            'types' => MicrositeTypes::getTypes(),
            'categories' => Category::all()
                ->select('id', 'name')
                ->pluck('name', 'id'),
        ]);
    }

    public function edit(Microsite $microsite): Response
    {
        return Inertia::render(
            'Microsites/Edit',
            [
                'currencies' => CurrencyTypes::getTypes(),
                'types' => MicrositeTypes::getTypes(),
                'categories' => Category::all()
                    ->select('id', 'name')
                    ->pluck('name', 'id'),
                'microsite' => $microsite
            ]
        );
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->all();
        $microsite = Microsite::findOrFail($id);
        $microsite->update($data);

        Cache::forget('guest.microsites');

        return redirect()->route('microsites.index')->with('success', 'Microsite actualizado exitosamente');
    }


    public function destroy(Microsite $microsite): RedirectResponse
    {
        $microsite->delete();

        Cache::forget('guest.microsites');

        Log::info('Micrositio ' . $microsite->name .  ' eliminado por: ' . auth()->user()->email);

        return redirect()->route('microsites.index');
    }

}
