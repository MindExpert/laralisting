<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return inertia('Index/Index', [
            'message' => 'Hello from Laravel!'
        ]);
    }

    public function show()
    {
        return inertia('Index/Show');
    }
}
