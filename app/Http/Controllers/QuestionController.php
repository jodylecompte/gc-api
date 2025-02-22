<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show($id)
    {
        // Remove non-numeric characters and pad the ID to the correct format (just a number)
        $cleanedId = preg_replace('/\D/', '', $id); // Remove all non-numeric characters

        // Find the question by ID
        $question = Question::find($cleanedId);

        // if (!$question) {
        //     return response()->json(['message' => 'Question not found'], 404);
        // }

        // Return the URL
        return response()->json(['url' => $question->url], 200, [], JSON_UNESCAPED_SLASHES);

    }
}
