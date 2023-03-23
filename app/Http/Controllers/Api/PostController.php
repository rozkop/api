<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        return PostResource::collection(Post::all());
    }


    public function store(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
           'title' => 'required',
           'text' => 'nullable',
        ]);

        $post = Post::create([
            'title' => $request['title'],
            'text' => $request['text'],
            'user_id' => $user_id
        ]);

        return PostResource::make($post);
    }


    public function show(string $username, string $id, string $slug): PostResource
    {
        $user = User::where('name', $username)->firstOrFail();

        $post = Post::where('user_id', $user->id)
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        return PostResource::make($post);
    }


    public function update(Request $request, string $id): PostResource
    {
        $user_id = Auth::id();

        $request->validate([
            'title' => 'required',
            'text' => 'nullable',
        ]);

        $post = Post::find($id);
        $post->update([
            'title' => $request['title'],
            'text' => $request['text'],
            'user_id' => $user_id
        ]);

        return PostResource::make($post);
    }


    public function destroy(string $id)
    {
        $user_id = Auth::id();
        $post = Post::where('user_id', $user_id)->where('id', $id);

        $post->delete();
    }
}
