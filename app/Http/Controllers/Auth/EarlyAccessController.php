<?php

namespace App\Http\Controllers\Auth;

use App\Models\EarlyAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class EarlyAccessController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->get('email');
        $exist = EarlyAccess::where('email', $email)->first();

        if(empty($exist)) {
            EarlyAccess::create($request->all());
            return response()->json(['type' => 'success', 'status' => Lang::get('auth.early_access.success')]);
        }

        return response()->json(['type' => 'error', 'status' => Lang::get('auth.early_access.error')]);
    }
}
