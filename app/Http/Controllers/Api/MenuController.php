<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
        $posts=Post::select('id','title','slug','image','author_id','created_at')->with(['category',function($query){
            $query->select('id','name','slug');
        }])->get();
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
