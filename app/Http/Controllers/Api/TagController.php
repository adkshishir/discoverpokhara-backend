<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
    $tags=Tag::select('id','name','slug')->with([
        'posts' => function ($query) {
            $query->select( 'title', 'slug');
        }
    ])->get();
    if($tags){
        return response()->json([
            'success'=>true,
            'status'=>200,
            'tags'=>$tags
        ],200);
    }
    else{
        return response()->json([
            'success'=>false,
            'status'=>404,
            'message'=>'No tag found'
        ],200);
    }
}
    public function show(string $slug){
        $tag=Tag::where('slug',$slug)->first()->select('id', 'name', 'slug')->with([
            'posts' => function ($query) {
                $query->select( 'title', 'slug', 'author_id','image');
            }
        ])->get();
        if($tag){
           return response()->json([
               'success'=>true,
               'status'=>200,
               'data'=>[
                   'tag'=>$tag,
                  
               ]
           ],200);
        }
        else{
           return response()->json([
               'success'=>false,
               'status'=>404,
               'message'=>'No tag found'
           ],200);
        }
     
    }
}

