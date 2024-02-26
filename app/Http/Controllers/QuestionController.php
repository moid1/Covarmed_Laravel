<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new Question();
        $item->question = $request->question;
        $item->content = $request->form;
        $item->save();

        $de_value = $request->input('de_value');
        $fr_value = $request->input('fr_value');

        $contentArray = json_decode( $item->content, true);
        if ($contentArray && is_array($contentArray) && !empty($contentArray)) {
            $label = $contentArray[0]['label'];
        }


        if (!empty($de_value) && !empty($label)) {
            $filePath = resource_path("lang/de.json");
            $translations = json_decode(File::get($filePath), true);
            $translations[$label] = $de_value;
            File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT));
        }
        if (!empty($fr_value) && !empty($label)) {
            $filePath = resource_path("lang/fr.json");
            $translations = json_decode(File::get($filePath), true);
            $translations[$label] = $fr_value;
            File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT));
        }
        return back()->with('success', trans('Question added succesfully, please edit the correct company to the question'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       Question::find($id)->delete();
       return back()->with('success', "Form deleted successfully");
    }
}
