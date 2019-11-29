<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function store()
    {
        return response([], Response::HTTP_CREATED);
    }
}
