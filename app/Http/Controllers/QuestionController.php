<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;

class QuestionController extends Controller
{
    public function lookup(Request $request, $param)
    {
        if (is_numeric($param)) {
            // Lookup by ID → Return URL
            $cleanedId = preg_replace('/\D/', '', $param);
            $question = Question::find($cleanedId);

            if (!$question) {
                return response()->json(['message' => 'Question not found'], 404);
            }

            return response()->json(['url' => $question->url], 200, [], JSON_UNESCAPED_SLASHES);
        } else {
            // Lookup by URL → Return ID (prefixed "G-XXX")
            $decodedUrl = base64_decode($param);
            $question = Question::where('url', $decodedUrl)->first();

            if (!$question) {
                return response()->json(['message' => 'Question not found'], 404);
            }

            $formattedId = sprintf("G-%03d", $question->id);
            return response()->json(['id' => $formattedId], 200);
        }
    }
}
