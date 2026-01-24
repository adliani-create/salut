<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;

class AjaxController extends Controller
{
    public function getProdisByFakultas($id)
    {
        if (!$id) {
            return response()->json([]);
        }

        $prodis = Prodi::where('fakultas_id', $id)->get();
        
        return response()->json($prodis);
    }
}
