<?php

namespace App\Http\Controllers;

use App\Models\Retro;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\RetrosColumns;

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
    public function show(Retro $retro)
    {
        $retro->load('columns'); 
        $user_id = \Illuminate\Support\Facades\Auth::user()->id;
    
        return view('pages.retros.show', compact('retro'), ['user_id' => $user_id]);
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


    /**
     * Function to fetch 
     */
    public function fetch($id){
        $columns = RetrosColumns::where('retro_id', $id)->get();

        $formated = $columns->map(function($column){
            $items = \DB::table('retros_data')
                ->where('column_id', $column->id)
                ->get();
            $formated_items = $items->map(function($item){
                return [
                    'id' => $item->id,
                    'column_id' => $item->column_id,
                    'name' => $item->name,
                    'description' => $item->description,
                ];
            });
            return [
                'id' => $column->id,
                'name' => $column->name,
                'items' => $formated_items,
            ];
        });
        return response()->json([
            'boards' => $formated,
        ]);
    }
}