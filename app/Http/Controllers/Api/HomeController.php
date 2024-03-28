<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashNew;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        try{
         $menuData=[];
         $categorys=Category::select('name','slug')->with(['posts'])->get();
         $recentPost=Post::select('id','title','slug','image','author_id')->with('author')->latest()->limit(6)->get();
         $popularPost=Post::select('id','title','slug','image')->with('author')->withCount('comments')->orderBy('comments_count','desc')->limit(6)->get();
         $flashNews=FlashNew::select('id','title','link')->latest()->limit(4)->get();
        if(!$categorys){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'message'=>'No category found'
            ],200);
        }
        foreach($categorys as $key=>$category){
            $menuData[$key]['name']=$category->name;
            $menuData[$key]['slug']=$category->slug;
            if(!$category->posts){
                $menuData[$key]['posts']=[];
                continue;
            }
            foreach($category->posts as $key1=>$post){
                $menuData[$key]['posts'][$key1]['title']=$post->title;
                $menuData[$key]['posts'][$key1]['slug']=$post->slug;
            }
        }
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>[
                'menuData'=>$menuData,
                'recentPost'=>$recentPost,
                'popularPost'=>$popularPost,
                'flashNews'=>$flashNews 
            ]
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
