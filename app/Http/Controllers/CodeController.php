<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CodeController extends Controller
{
    public function createCode(Request $req)
    {
        $validated_data = $req->validate([
            "title" => "required|string|max:255",
            "code" => "required|string|min:0"
        ]);
        $validated_data['user_id'] = 4;
        $code = new Code;
        $code->fill($validated_data);
        $code->save();
        return response()->json([
            "code" => $code,
            "message" => 'created successfully'
        ], 201);
    }



    public function getAllCode()
    {
        $code = Code::all();
        return response()->json([
            "code" => $code
        ], 200);
    }

    public function getCode($id)
    {
        $code = Code::find($id);
        return response()->json([
            "code" => $code
        ], 200);
    }



public function updateCode(Request $req, $id)
{
    try {
        $code = Code::find($id);
        if (!$code) {
            return response()->json(['message' => 'Code not found'], 404);
        }

        $validated_data = $req->validate([
            "title" => "required|string|max:255",
            "code" => "required|string",
            "user_id" => "required|exists:users,id|numeric",
        ]);

        $code->update($validated_data);

        return response()->json(['message' => 'updated successfully'], 204);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Log the validation errors
        Log::error('Validation Error:', $e->errors());

        return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Log the exception for debugging
        Log::error($e);

        return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
}



    public function deleteCode($id)
    {
        $code = Code::find($id);
        $code->delete();
        if ($code) {
            $code->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Code not found'], 404);
        }
    }


}