<?php

namespace App\Http\Controllers;

use App\Friend;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Friend as FriendResource;
use App\Exceptions\FriendRequestNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestResponseController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'user_id' => 'required',
            'status' => 'required'
        ]);

        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new FriendRequestNotFoundException();

        }

        $friendRequest->update(array_merge($data, [
            'confirmed_at' => now()
        ]));

        return new FriendResource($friendRequest);
    }

    public function destroy()
    {
        $data = request()->validate([
            'user_id' => 'required'
        ]);

        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail()
                ->delete();
        } catch (ModelNotFoundException $e) {
            throw new FriendRequestNotFoundException();

        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
