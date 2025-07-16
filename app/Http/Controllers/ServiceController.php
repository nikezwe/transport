<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): Response
    {
        $services = Service::all();

        return view('service.index', [
            'services' => $services,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('service.create');
    }

    public function store(ServiceStoreRequest $request): Response
    {
        $service = Service::create($request->validated());

        $request->session()->flash('service.id', $service->id);

        return redirect()->route('services.index');
    }

    public function show(Request $request, Service $service): Response
    {
        return view('service.show', [
            'service' => $service,
        ]);
    }

    public function edit(Request $request, Service $service): Response
    {
        return view('service.edit', [
            'service' => $service,
        ]);
    }

    public function update(ServiceUpdateRequest $request, Service $service): Response
    {
        $service->update($request->validated());

        $request->session()->flash('service.id', $service->id);

        return redirect()->route('services.index');
    }

    public function destroy(Request $request, Service $service): Response
    {
        $service->delete();

        return redirect()->route('services.index');
    }
}
