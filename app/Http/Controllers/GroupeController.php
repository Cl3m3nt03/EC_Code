<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Services\MistralService;
use App\Models\User;
use App\Models\GroupeUser;

class GroupeController extends Controller
{
    /**
     * Function to create a new group with prompt and Mistral API
     * @param MistralService $mistral
     * @param Request $request
     */

    public function store(Request $request, MistralService $mistral)
    {
        $validated = $request->validate([
            'promotion_id' => 'required|exists:promotions,id',
            'tentacles' => 'required|integer|min:1|max:4',
        ]);

        // Retrieves students in the year who are already in a group
        $groupedUserIds = GroupeUser::where('promotion_id', $validated['promotion_id'])
            ->pluck('user_id')
            ->toArray();

        // Retrieves students in the year who are NOT yet in a group
        $students = User::select('id', 'last_name', 'first_name', 'skill_assessment')
            ->where('promotion_id', $validated['promotion_id'])
            ->whereNotIn('id', $groupedUserIds)
            ->get();

        // if students is empty, return an error message
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', "Tous les étudiants sont déjà dans un groupe. Aucun nouveau groupe ne peut être créé.");
        }

        // build the student list for the prompt
        $studentList = $students->map(function ($student) {
            return "{$student->id}|{$student->last_name} {$student->first_name} (Skill: {$student->skill_assessment})";
        })->join(', ');

        // Prompt for Mistral
        $prompt = "Here is the list of students from the selected promotion: {$studentList}. Each student has a skill level represented by the attribute skill_assessment (a number between 1 and 20, where 1 is the lowest and 20 is the highest). 
     Your task is to create homogeneous groups of students by following these steps:
     1. Shuffle the students based on their skill level (skill_assessment).
     2. Divide the students into multiple groups, strictly respecting the maximum size of {$validated['tentacles']} students per group.
     3. Ensure that each group contains a balance between skill levels:
         - Strong: Students with a skill_assessment greater than or equal to 10.
         - Weak: Students with a skill_assessment less than 10.
         - For example, in a group of {$validated['tentacles']} students, there should be a balanced distribution of strong and weak students (e.g., 2 strong and 1 weak for a group of 3).
     4. If the total number of students does not allow for complete groups (i.e., not a multiple of {$validated['tentacles']}), create groups with the maximum possible size. If you can't divide them evenly, create smaller groups to ensure the balance remains.
     5. Maintain this balance to ensure diversity in all groups.
     
     IMPORTANT:
     - Return ONLY the groups in JSON format.
     - Do NOT include any other information such as Python code or explanations.
     - The JSON MUST follow this exact structure:
     
     EXEMPLE : 
     [
       {
         \"groupe\": \"Groupe 1\",
         \"membres\": [\"Nom + skill_assessment, Nom + skill_assessment, Nom + skill_assessment\"]
       }
     ]";

        try {
            // CALL API Mistral
            $result = $mistral->generateText($prompt);
            preg_match('/\[\s*{.*}\s*]/s', $result, $matches);

            if (!isset($matches[0])) {
                throw new \Exception("Impossible d'extraire un tableau JSON depuis la réponse brute");
            }

            $jsonClean = $matches[0];
            $decoded = json_decode($jsonClean, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Erreur JSON après extraction : " . json_last_error_msg());
            }

            $groups = [];
            $addedStudents = [];

            foreach ($decoded as $group) {
                $groupMembers = [];
                foreach (explode(', ', $group['membres'][0]) as $member) {
                    $studentName = explode(' ', $member)[0];
                    if (!in_array($studentName, $addedStudents)) {
                        $groupMembers[] = $member;
                        $addedStudents[] = $studentName;
                    }
                }

                if (!empty($groupMembers)) {
                    $group['membres'] = $groupMembers;
                    $groups[] = $group;
                }
            }

            // check if groups is empty
            if (empty($groups)) {
                return redirect()->back()->with('error', "L'IA n'a pas pu créer de groupes. Veuillez vérifier les données ou réessayer.");
            }

            // insert groups in the database
            foreach ($groups as $group) {
                $groupRecord = Groupe::create([
                    'nom' => $group['groupe'],
                    'promotion_id' => $validated['promotion_id'],
                ]);

                foreach ($group['membres'] as $member) {
                    $studentName = explode(' ', $member)[0];
                    $student = User::where('last_name', $studentName)->first();

                    if ($student) {
                        $alreadyInGroup = $student->groupes()
                            ->wherePivot('promotion_id', $validated['promotion_id'])
                            ->exists();

                        if (!$alreadyInGroup) {
                            $groupRecord->users()->attach($student->id, [
                                'promotion_id' => $validated['promotion_id']
                            ]);
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'Groupes créés avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Erreur lors de l'appel à l'API : " . $e->getMessage());
        }
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
        // delete usee in the pivot table
        $groupe->users()->detach();


        return redirect()->back()->with('success', 'Groupe supprimé avec succès.');
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
        $groupe->save();

        return redirect()->back()->with('success', 'Groupe modifié avec succès.');
    }
}