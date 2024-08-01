<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class instructorController extends Controller
{
    public function deactivateInstructor(Request $request) {
        $user = User::find($request->user_id);

        if ($user) {
            $user->availability = 0;
            $user->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 400);
    }

    public function activateInstructor(Request $request) {
        $user = User::find($request->user_id);
        if ($user) {
            $user->availability = 1;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
