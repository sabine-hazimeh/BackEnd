<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ChatController extends Controller
{
    public function getAllChats(){
        $chats = Chat::all();
        return response()->json([
            "chats" => $chats
        ], 200);
    }
    public function getAllUsers(){
        $users = User::all();
        return response()->json([
            "users" => $users
        ], 200);
    }
    // public function getMessages($receiverId){
    //     $userId = auth()->id();
    //     $receiverId = 1;
    //     $messages = Chat::where(function ($query) use ($userId, $receiverId) {
    //         $query->where('sender_id', $userId)
    //               ->where('receiver_id', $receiverId);
    //     })
    //     ->orWhere(function ($query) use ($userId, $receiverId) {
    //         $query->where('sender_id', $receiverId)
    //               ->where('receiver_id', $userId);
    //     })
    //     ->get();

    //     return response()->json($messages);
    // }
    public function getMessages($receiverId)
    {
        $userId = auth()->id();
    
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $messages = Chat::where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $receiverId);
        })
        ->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
        return response()->json($messages);
    }
    
    public function getChat($id){
        $chat = Chat::find($id);
        return response()->json([
            "chat" => $chat
        ]);
    }
    public function createChat(Request $req){
        $authorizationHeader = $req->header('Authorization');
        Log::info('Received Authorization Header:', ['Authorization' => $authorizationHeader]);
        $validated_data = $req->validate([
            "receiver_id" => "required|exists:users,id|numeric",
            "message" => "required|string|max:255"
        ]);
    
        
        //  $validated_data['sender_id'] = 152;  
        $validated_data['sender_id'] = auth()->id();
        $chat = new Chat;
        $chat->fill($validated_data);
        $chat->save();
    
        return response()->json([
            "chat" => $chat,
            "message" => 'created successfully'
        ], 201);
    }
    
    // public function createChat(Request $req) {
    //     $validated_data = $req->validate([
    //         "receiver_id" => "required|exists:users,id|numeric",
    //         "message" => "required|string|max:255"
    //     ]);
    
    //     $validated_data['sender_id'] = auth()->id();  // Use the authenticated user's ID
    
    //     $chat = new Chat;
    //     $chat->fill($validated_data);
    //     $chat->save();
    
    //     return response()->json([
    //         "chat" => $chat,
    //         "message" => 'created successfully'
    //     ], 201);
    // }
    
    public function updateChat(Request $req, $id){
    try {
        $chat = Chat::find($id);
        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        $validated_data = $req->validate([
                          "sender_id" => "required|exists:users,id|numeric",
                "receiver_id" => "required|exists:users,id|numeric",
                "message" => "required|string|max:255"
        ]);

        $chat->update($validated_data);

        return response()->json(['message' => 'updated successfully'], 204);
    } catch (\Illuminate\Validation\ValidationException $e) {
       
        Log::error('Validation Error:', $e->errors());

        return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        
        Log::error($e);

        return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
    }
    public function deleteChat($id){
        $chat = Chat::find($id);
        if($chat){
            $chat -> delete();
        }
        return response()->json([
            "message" => "deleted successfully"
        ], 204);
    }
}
