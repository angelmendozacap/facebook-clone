<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\ValidationErrorException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Friend as FriendResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendRequestController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'friend_id' => 'required'
        ]);

        try {
            User::findOrFail($data['friend_id'])
                ->friends()->attach(auth()->user());
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return new FriendResource(
            Friend::where('user_id', auth()->user()->id)
                ->where('friend_id', $data['friend_id'])
                ->first()
        );
    }
}
