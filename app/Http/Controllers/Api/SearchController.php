<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public Function search(string $search){
     $search=trim($search);
     $post=Post::select('id','title','slug','image')->where('title','like','%'.$search.'%')->orWhere('content','like','%'.$search.'%')->get();
     if($post){
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>$post
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
