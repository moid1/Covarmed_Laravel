<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{

    public function create()
    {
        return view('translations.create');
    }


    public function translationsStore(Request $request) {
    $text = $request->input('data');
    $value = $request->input('value');
    $language = $request->input('language');

    // Determine the file path based on the selected language
    $filePath = resource_path("lang/$language.json");

    // Read the existing contents of the language file
    $translations = json_decode(File::get($filePath), true);

    // Add or update the translation in the language file
    $translations[$text] = $value; // Here, we use the input text as both key and value for demonstration. Replace $text with the actual translation.

    // Write the updated contents back to the language file
    File::put($filePath, json_encode($translations, JSON_PRETTY_PRINT));

    return redirect()->back()->with('success', 'Data stored successfully.');
}
}
