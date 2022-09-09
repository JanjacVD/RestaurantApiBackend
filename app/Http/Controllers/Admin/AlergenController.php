<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alergen;
use Illuminate\Http\Request;
use App\Models\Lang;

class AlergenController extends Controller
{
    public function index()
    {
        $alergens = Alergen::all();
        return response()->json(['alergens' => $alergens]);
    }

    public function getTrashed()
    {
        $alergens = Alergen::onlyTrashed()->get();
        return response()->json(['alergens' => $alergens]);
    }
    public function store(Request $request)
    {
        $sentLang = $request->sentLang;
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            Alergen::create([
                'title' => [
                    $request->title,
                ],
            ]);
            return response(['status' => 'Created'], 201);
        } else {
            abort(400);
        }
    }


    public function show($id)
    {
        $alergen = Alergen::withTrashed()->findOrFail($id);
        return response()->json(['alergens' => $alergen]);
    }

    public function update(Request $request, $id)
    {
        $sentLang = $request->sentLang;
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            $alergen = Alergen::findOrFail($id);
            $alergen->title = $request->title;
            $alergen->save();
            return response(['status' => 'updated'], 202);
        } else {
            abort(400);
        }
    }

    public function restore($id)
    {
        $alergen = Alergen::withTrashed()->findOrFail($id);
        $alergen->restore();
        return response()->noContent();
    }
    public function destroy($id)
    {
        $alergen = Alergen::findOrFail($id);
        $alergen->delete();
        return response()->noContent();
    }

    public function forceDestroy($id)
    {
        Alergen::withTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['status' => 'Deleted'], 204);
    }
}
