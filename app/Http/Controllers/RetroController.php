<?php

namespace App\Http\Controllers;

use App\Models\Retro;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class RetroController extends Controller
{
    /**
     * Display the page
     *
     * @return Factory|View|Application|object
     */
    public function index() {
        return view('pages.retros.index');
    }

    /**
     * Function to create a new retro
     * request
     * @param Request $request
     */

     public function create(Request $request) {
        $validated = $request->validate([
            'promotion_id' => 'required|exists:promotions,id',
            'name' => 'required|string|max:255',
        ]);        

        
        $validated = Retro::create([
            'promotion_id' => $validated['promotion_id'],
            'name' => $validated['name'],
        ]);

    
        return redirect()->route('retros.show', $validated->id)->with('success', 'Rétrospective créée avec succès.');
    }

    /**
     * Function to show a retro
     * @param Retro $retro
     * @return Factory|View|Application|object
     */

    public function show(\App\Models\Retro $retro)
    {   
        return view('pages.retros.show', compact('retro'));
    }
    
    /**
     * Function to delete a retro
     * @param Retro $retro
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(\App\Models\Retro $retro)
    {
        $retro->delete();
        return redirect()->back()->with('success', 'Rétrospective supprimée avec succès.');
    }

}