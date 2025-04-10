<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Services\MistralService;
use App\Models\User;

class GroupeController extends Controller
{
    /**
     * Function to create a new group
     * @param Request $request
     */
    public function store(Request $request, MistralService $mistral)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'promotion_id' => 'required|exists:promotions,id',
            'tentacles' => 'required|integer|min:1|max:4',
        ]);
    
        // Recup students with the same promotion_id
        $students = User::select('id', 'last_name', 'skill_assessment')
            ->where('promotion_id', $validated['promotion_id']) // Filtrer par promotion_id
            ->get();
    
        // Build the prompt
        $studentList = $students->map(function ($student) use ($validated) {
            return "{$student->last_name} (Skill: {$student->skill_assessment}, Promotion ID: {$validated['promotion_id']})";
        })->join(', ');
    
        $prompt = "Voici une liste veuillez ecrire leur nom et leur promotion ID : {$studentList}. Que pouvez-vous en dire ?";
    
        // send the prompt to the Mistral API
        $result = $mistral->generateText($prompt);
    
        // Return the result
        return redirect()->back()->with('success', "Groupe créé avec succès. Réponse de l'IA : " . nl2br(e($result)));
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
