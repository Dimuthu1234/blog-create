<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $posts = Post::with(['comments' => function ($query) use ($request) {
                $query->orderBy('created_at', 'asc');
            }])->orWhereHas('comments', function ($query) use ($request) {
                $query->where('comment', 'like', '%' . $request['search'] . '%');
            })->orWhere('title', 'like', '%' . $request['search'] . '%')
                ->orWhere('description', 'like', '%' . $request['search'] . '%')
                ->get();
            if (count($posts) > 0)
                return response()->json($posts, 200);

                return response()->json(['message' => 'Post content could not found!'], 204);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPost()
    {
        try {
            $posts = Post::with(['comments' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])->get();
            return response()->json($posts, 200);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPostByID(Request $request)
    {
        try {
            $posts = Post::with(['comments' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])->where('id', '=', $request['post_id'])->first();
            return response()->json($posts, 200);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
