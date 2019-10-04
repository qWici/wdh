<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Validator;

class SuggestionController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|min:3|string',
            'link' => 'required|active_url'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => "error", "errors" => $validator->errors()]);
        }

        $newSuggestion = new Suggestion($request->all());
        $newSuggestion->save();

        return response()->json(["message" => "ok", "errors" => []]);
    }
}
