<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessagesRequest;
use App\Http\Resources\MessagesResource;
use App\Models\Messages;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        $data = MessagesResource::collection(Messages::paginate(Messages::count()));
        return $data;
    }

    public function store(MessagesRequest $request)
    {
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $val->createTranslations($request->translations);

        Messages::create([
            'title' => $request->title,
            'message' => $translations,
        ]);
        return response()->json(['status' => 'created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu\FoodSection  $foodSection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = new MessagesResource(Messages::findOrFail($id));
        return $data;
    }
    public function update(MessagesRequest $request, $id)
    {
        $time = Messages::findOrFail($id);
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $val->createTranslations($request->translations);
        if ($val->failed) {
            return $this->failedLang();
        }
        $time->update([
            'title' => $translations
        ]);
        return response()->json(['status' => 'updated'], 201);
    }
}
