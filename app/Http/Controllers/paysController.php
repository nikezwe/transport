<?php

namespace App\Http\Controllers;

use App\Http\Requests\payStoreRequest;
use App\Http\Requests\payUpdateRequest;
use App\Models\Pays;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class paysController extends Controller
{
    public function index(Request $request): Response
    {
        $pays = Pay::all();

        return view('pay.index', [
            'pays' => $pays,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('pay.create');
    }

    public function store(payStoreRequest $request): Response
    {
        $pay = Pay::create($request->validated());

        $request->session()->flash('pay.id', $pay->id);

        return redirect()->route('pays.index');
    }

    public function show(Request $request, pay $pay): Response
    {
        return view('pay.show', [
            'pay' => $pay,
        ]);
    }

    public function edit(Request $request, pay $pay): Response
    {
        return view('pay.edit', [
            'pay' => $pay,
        ]);
    }

    public function update(payUpdateRequest $request, pay $pay): Response
    {
        $pay->update($request->validated());

        $request->session()->flash('pay.id', $pay->id);

        return redirect()->route('pays.index');
    }

    public function destroy(Request $request, pay $pay): Response
    {
        $pay->delete();

        return redirect()->route('pays.index');
    }
}
