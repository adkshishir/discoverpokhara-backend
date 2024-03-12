<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class MenuController extends Controller
{
    public function index(){
        $posts=Post::select('title','slug','image')->latest()->paginate(13);
        if($posts){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'posts'=>$posts
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'status'=>404,
                'message'=>'No post found'
            ],200);
        }
    }
}
