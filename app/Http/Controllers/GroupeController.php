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
            'promotion_id' => 'required|exists:promotions,id',
        ]);
    
        Groupe::create($validated);
    
        return redirect()->back()->with('success', 'Groupe créé avec succès.');
    }

    /**
     * Function to delete a group
     * @param Request $request
     * @param int $id
     */
    public function destroy($id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();
    
        return redirect()->back()->with('success', 'Groupe supprimé avec succès.');
    }

    /**
     * Function for editing a group
     * @param int $id
     */
    public function edit($id)
    {
        $groupe = Groupe::findOrFail($id);
        return view('groupes.edit', compact('groupe'));
    }

    /**
     * Function to update a group
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
{
    $groupe = Groupe::findOrFail($id);
    $groupe->nom = $request->nom;
    $groupe->promotion_id = $request->promotion_id;
    $groupe->save();

    return redirect()->back()->with('success', 'Groupe modifié avec succès.');
}
}
