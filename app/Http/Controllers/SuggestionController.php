<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function add(Request $request)
    {
        $newSuggestion = new Suggestion();
        $newSuggestion->text = $request->get('text');
        $newSuggestion->save();

        return response()->json(["message" => "ok"]);
    }
}
