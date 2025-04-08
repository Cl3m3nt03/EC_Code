<?php

namespace App\Http\Controllers;

use App\Services\MistralService;
use Illuminate\Http\Request;

class MistralController extends Controller
{
    protected $mistralService;

    public function __construct(MistralService $mistralService)
    {
        $this->mistralService = $mistralService;
    }

    public function fetchData(Request $request)
    {
        $endpoint = '/fetch-data'; 
        $data = $request->all();

        $response = $this->mistralService->generateText($data['prompt']);

        return response()->json($response);
    }
}

