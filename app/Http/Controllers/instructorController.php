<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function deleteInstructor($id) {
        $instructor = User::findOrFail($id);
    
        // Optionally, delete the thumbnail from storage
        if ($instructor->hash_for_profile_picture) {
            Storage::delete('profile_picture/' . $instructor->hash_for_profile_picture);
        }

        $instructor->delete();

        // Check if the user has any remaining instructors
        $remainingInstructors = User::where('admin_id', auth()->id())->count();

        if ($remainingInstructors == 0) {
            session()->flash('warning', 'Anda sudah tidak memiliki Instruktur lagi!');
        } else {
            session()->flash('success', 'Instruktur Berhasil Dihapus');
        }

        return redirect()->intended('/admin-manage-instructor');
    }
}
