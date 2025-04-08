<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;

class GroupeController extends Controller
{
    /**
     * Function to create a new group
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'promotion' => 'required|string|max:255',
        ]);
    
        Groupe::create($validated);
    
        return redirect()->back()->with('success', 'Groupe créé avec succès.');
    }
}
