<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seo;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
    $tags=Tag::select('id','name','slug')->with([
        'posts' => function ($query) {
            $query->select( 'title', 'slug','image');
        }
    ])->latest()->get();
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
        $tag=Tag::where('slug',$slug)->select('id', 'name', 'slug')->with([
            'posts' => function ($query) {
                $query->select( 'title', 'slug', 'author_id','image');
            }
        ])->get()->first();
        $seo=Seo::where('parent_id',$tag->id)->where('seo_type','tags')->select('meta_title','meta_description','meta_keywords','schema')->first();
        if($tag){
           return response()->json([
               'success'=>true,
               'status'=>200,
               'data'=>[
                   'tag'=>$tag,   
                   'seo'=>$seo
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

