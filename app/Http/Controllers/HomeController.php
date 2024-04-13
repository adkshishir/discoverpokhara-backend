<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categoryCount = Category::count();
        $tagsCount = Tag::count();
        $postCount = Post::count();
        $commentcount = Comment::count();
        $viewCount = Post::count();
        $response['status'] = 200;
        $response['categoryCount'] = $categoryCount;
        $response['tagsCount'] = $tagsCount;
        $response['postCount'] = $postCount;
        $response['commentCount'] = $commentcount;
        $response['viewCount'] = $viewCount;
        // dd($response);
        return view('welcome', $response);
    }
}
