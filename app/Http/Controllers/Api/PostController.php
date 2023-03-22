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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $username, string $id, string $slug): PostResource
    {
        $user = User::where('name', $username)->firstOrFail();

        $post = Post::where('user_id', $user->id)
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_id = Auth::id();
        $post = Post::where('user_id', $user_id)->where('id', $id);

        $post->delete();
    }
}
