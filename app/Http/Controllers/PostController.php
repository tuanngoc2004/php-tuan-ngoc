<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        return Post::create($request->all());
    }

    public function show($id)
    {
        return Post::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pots = Post::findOrFail($id);
        $pots->update($request->all());
        return $pots;
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return 204;
    }
}
