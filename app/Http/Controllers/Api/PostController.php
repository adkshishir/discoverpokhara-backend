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
        $posts = Post::select('id', 'title', 'h1', 'is_published', 'slug', 'author_id')->get();
        $postWithImage=[];
        foreach($posts as $post){
            $postWithImage[]=[
                'id'=>$post->id,
                'title'=>$post->title,
                'slug'=>$post->slug,
                'h1' => $post->h1,
                'is_published' => $post->is_published,
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
            $post = Post::where('slug', $slug)->select('id', 'title', 'h1', 'is_published', 'slug', 'updated_at', 'category_id', 'author_id')->with([
                'tags',
                'category' => function ($q) {
                    $q->select('id', 'title', 'slug'); },
                'seo',
                'author',
                'contents' => function ($q) {
         $q->with('special_sections');
        }])->first();
        $image=$post?->getMedia('posts')?->first()?->getFullUrl();
        $related=Post::where('id','!=',$post->id)->where('author_id',$post->author_id)->latest()->take(7)->select('id','title','slug','category_id')->get();
        $relatedPost=[];
        foreach($related as $key=>$rel){
            $relatedPost[$key]['id']=$rel->id;
            $relatedPost[$key]['title']=$rel->title;
            $relatedPost[$key]['slug']=$rel->slug;
            $relatedPost[$key]['image']=$rel->getMedia('posts')->first()?->getFullUrl();
            $relatedPost[$key]['category']=$rel->category;
                $relatedPost[$key]['tags'] = $rel->tags->select('id', 'title', 'slug')->first();
        }
        if(!$post){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'message'=>'Post not found'
            ],200);}
        $data = [
            'post' => $post,
            'relatedPost' => $relatedPost,
            'image' => $image
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
