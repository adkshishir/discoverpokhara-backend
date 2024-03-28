<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Post;
use App\Models\Seo;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts=Post::select('id','title','slug','image','author_id')->get();
        $postWithImage=[];
        foreach($posts as $post){
            $postWithImage[]=[
                'id'=>$post->id,
                'title'=>$post->title,
                'slug'=>$post->slug,
                'image'=>$post->getMedia('image')->first(),
                'author_id'=>$post->author_id
            ];
        }
        
        if($posts){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'posts'=>$postWithImage
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
    public function show(string $slug)
    {
     try{
        $post=Post::where('slug',$slug)->with(['seo','author','contents'=>function ($q){
         $q->with('special_sections');
        }])->first();
        // $seo=Seo::where('parent_id',$post->id)->where('seo_type','post')->first();
        // $author=Author::where('id',$post->author_id)->select('id', 'name', 'avatar')->first();
        $relatedPost=Post::where('id','!=',$post->id)->where('author_id',$post->author_id)->latest()->take(7)->select('id','title','slug','image')->get();
        
        if(!$post){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'message'=>'Post not found'
            ],200);}
        $data = [
            'post' => $post,
            // 'seo' => $seo,
            // 'author' => $author,
            'relatedPost' => $relatedPost
        ];
       return response()->json([
         'success'=>true,
         'status'=>200,
         'data'=>$data
       ],200);
    }
     
     catch(Exception $e){
        return response()->json([
            'success'=>false,
            'status'=>500,
            'message'=>$e->getMessage()
        ],200);
     }
    }
}
