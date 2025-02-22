<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function lookup(Request $request, $param = null)
    {
        if ($request->isMethod('post')) {
            // Handle POST for URL lookup
            $url = $request->input('url');  // Get URL from the POST JSON body

            if (!$url) {
                return response()->json(['message' => 'URL not provided'], 400);
            }

            // Lookup by URL → Return ID (prefixed "G-XXX")
            $question = Question::where('url', $url)->first();

            if (!$question) {
                return response()->json(['message' => 'Question not found'], 404);
            }

            $formattedId = sprintf("G-%03d", $question->id);
            return response()->json(['id' => $formattedId], 200);
        } else {
            // Handle GET for ID lookup
            if (is_numeric($param)) {
                // Lookup by ID → Return URL
                $cleanedId = preg_replace('/\D/', '', $param);
                $question = Question::find($cleanedId);

                if (!$question) {
                    return response()->json(['message' => 'Question not found'], 404);
                }

                return response()->json(['url' => $question->url], 200, [], JSON_UNESCAPED_SLASHES);
            } else {
                return response()->json(['message' => 'Invalid ID or URL format'], 400);
            }
        }
    }
}
