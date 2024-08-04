<?php

namespace App\Http\Controllers\Admin\Microsites;

use App\Constants\CurrencyTypes;
use App\Constants\MicrositeTypes;
use App\Domain\Microsites\Actions\StoreMicrositeAction;
use App\Domain\Microsites\Actions\UpdateMicrositeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Microsites\StoreMicrositeRequest;
use App\Http\Requests\Microsites\UpdateMicrositeRequest;
use App\Infrastructure\Persistence\Models\Category;
use App\Infrastructure\Persistence\Models\Microsite;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MicrositesController extends Controller
{
    use AuthorizesRequests;
    public function index(): Response
    {
        $this->authorize('viewAny', Microsite::class);
        return Inertia::render('Microsites/Index', ['microsites' => Microsite::all()]);
    }

    public function create(): Response
    {
        $this->authorize('create', Microsite::class);
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
        $this->authorize('store', Microsite::class);
        $action->execute($request->validated());

        Cache::forget('guest.microsites');

        Log::info('Nuevo micrositio con el nombre ' . request('name').' creado por:' . auth()->user()->email);

        return redirect()->route('microsites.index');
    }

    public function show(Microsite $microsite): Response
    {
        $this->authorize('show', Microsite::class);

        return Inertia::render('Microsites/Show', [
            'microsite' => $microsite->load(['category', 'form']),
        ]);
    }

    public function edit(Microsite $microsite): Response
    {
        $this->authorize('edit', Microsite::class);
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

    public function update(UpdateMicrositeRequest $request, string $id, UpdateMicrositeAction $action): RedirectResponse
    {
        $this->authorize('update', Microsite::class);

        $action->execute($request->validated(), $id);

        Cache::forget('guest.microsites');

        return redirect()->route('microsites.index')->with('success', 'Microsite actualizado exitosamente');
    }


    public function destroy(Microsite $microsite): RedirectResponse
    {
        $this->authorize('delete', Microsite::class);
        $microsite->delete();

        Cache::forget('guest.microsites');

        Log::info('Micrositio ' . $microsite->name .  ' eliminado por: ' . auth()->user()->email);

        return redirect()->route('microsites.index');
    }

}
