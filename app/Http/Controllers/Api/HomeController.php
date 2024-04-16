<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashNew;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class HomeController extends Controller
{
    public function index(){
        try{
         $menuData=[];
         $categorys=Category::select('id','title','slug')->with(['posts'])->get();
         $recentPost=Post::select('id','title','slug','author_id','category_id')->with(['author','tags','category'=>function ($q){$q->select('id','title','slug');}])->latest()->limit(6)->get();
         $popularPost=Post::select('id','title','slug','author_id','category_id')->with(['author','tags','category'=>function ($q){$q->select('id','title','slug');}])->withCount('comments')->orderBy('comments_count','desc')->limit(6)->get();
         $flashNews=FlashNew::select('id','title','link')->latest()->limit(4)->get();
         $recentPostWithImage=Helper::dataWithImage($recentPost,'posts');
         $popularPostWithImage=Helper::dataWithImage($popularPost,'posts');
        
        if(!$categorys){
            return response()->json([
                'success'=>false,
                'status'=>404,
                'message'=>'No category found'
            ],200);
        }
        foreach($categorys as $key=>$category){
            $menuData[$key]['title']=$category->title;
            $menuData[$key]['slug']=$category->slug;

            if(!$category->posts){
                $menuData[$key]['posts']=[];
                continue;
            }
            foreach($category->posts as $key1=>$post){
                $menuData[$key]['posts'][$key1]['title']=$post->title;
                $menuData[$key]['posts'][$key1]['slug']=$post->slug;
                $menuData[$key]['tags']=$post->tags->select('id','title','slug')->first();
                
            }
        }
        return response()->json([
            'success'=>true,
            'status'=>200,
            'data'=>[
                'menuData'=>$menuData,
                'recentPost'=>$recentPostWithImage,
                'popularPost'=>$popularPostWithImage,
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
