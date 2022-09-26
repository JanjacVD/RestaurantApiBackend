<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LangRequest;
use App\Jobs\DeleteTranslations;
use App\Models\Lang;
use Illuminate\Http\Request;

class LangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lang::all(['lang_code', 'lang_name']);
        return response()->json(['data' => $data], 200);
    }
    public function store(LangRequest $request)
    {
        $langCode = $request->lang_code;
        $langName = $request->lang_name;
        Lang::create([
            'lang_name' => $langName,
            'lang_code' => $langCode,
        ]);
        return response()->json(['status' => 'created'], 201);
    }

    public function update(LangRequest $request, $id)
    {
        $langName = $request->lang_name;
        Lang::findOrFail($id)->update([
            'lang_name' => $langName,
        ]);
        return response()->json(['status' => 'updated'], 201);
    }
    public function destroy($id)
    {
        $lang = Lang::findOrFail($id);
        $lang->delete();
        DeleteTranslations::dispatch($lang->lang_code)->onQueue('high');
        return response()->noContent();
    }
}
 //TODO: LANG, on delete, forget translations for every model