<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
        $companies = Company::with('question')->get();
        return view('questions.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        $companies = Company::all();

        return view('questions.create', compact('questions', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // check if question already available just entering the translations
        if ($request->question_available) {
            $question = Question::findOrFail($request->question_available);
            if ($question) {
                $language = $request->language;
                switch ($language) {
                    case 'en':
                        $question->content = $request->form;
                        break;
                    case 'fr':
                        $question->content_fr = $request->form;
                        break;
                    case 'nl':
                        $question->content_nl = $request->form;
                        break;
                    default:
                        $question->content = $request->form;
                }
                $question->update();
                return back()->with('success', trans('Question added successfully'));
            }
        }
        $item = new Question();
        $item->question = $request->form_name;
        $company = Company::findOrFail($request->company);

        // Determine which content column to use based on language
        $language = $request->language;
        switch ($language) {
            case 'en':
                $item->content = $request->form;
                break;
            case 'fr':
                $item->content_fr = $request->form;
                break;
            case 'nl':
                $item->content_nl = $request->form;
                break;
            default:
                $item->content = $request->form;
        }

        $item->save();
        $company->questions = $item->id;
        $company->update();

        return back()->with('success', trans('Question added successfully, please edit the correct company to the question'));
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

    public function showQuestion($id)
    {
        $question = Question::find($id);
        if ($question) {
            $contentArray = json_decode($question->content, true);
            if ($contentArray && is_array($contentArray) && !empty($contentArray)) {
                return view('questions.show', compact('contentArray'));
            }
        }
    }

    public function updateQuestionTranslation(Request $request)
    {
        $question = Question::find($request->question_id);
        if ($question) {
            $contentArray = json_decode($question->content, true);
            if ($contentArray && is_array($contentArray) && !empty($contentArray)) {
                $contentArray[0]['label'] = $request->eng_value;
                $question->content = json_encode($contentArray);
                $question->save();
            }

            $filePath = resource_path("lang/de.json");
            $translations = json_decode(File::get($filePath), true);
            $translations[$request->eng_value] = $request->de_value;
            File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT));

            $filePath = resource_path("lang/fr.json");
            $translations = json_decode(File::get($filePath), true);
            $translations[$request->eng_value] = $request->fr_value;
            File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT));

            return redirect('/questions');
        }
    }
}
