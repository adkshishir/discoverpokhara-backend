<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Seo;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index(){
   try{
    
    $categories = Category::select('id','name','slug','image')->with(['posts'])->get();
    $tempCategorys=[];
    foreach($categories as $key=>$category){
        $tempCategorys[$key]['id']=$category->id;
        $tempCategorys[$key]['name']=$category->name;
        $tempCategorys[$key]['slug']=$category->slug;
        $tempCategorys[$key]['image']=$category->image;
         foreach($category->posts as $key1=>$post){
            $tempCategorys[$key]['posts'][$key1]['id']=$post->id;
            $tempCategorys[$key]['posts'][$key1]['title']=$post->title;
            $tempCategorys[$key]['posts'][$key1]['slug']=$post->slug;

            
         }
    }
    if($categories){
        return response()->json([
            'success'=>true,
            'status'=>200,
            'categories'=>$tempCategorys
        ],200);
    }
    else{
        return response()->json([
            'success'=>false,
            'status'=>404,
            'message'=>'No category found'
        ],200);
    }
   }
   catch(Exception $e){
    return response()->json([
        'success'=>false,
        'status'=>500,
        'message'=>$e->getMessage()
    ],200);
   }
}
public function show(string $slug){
         $category=Category::where('slug',$slug)->with(['seo'])->get()->first();
         $post=Post::where('category_id',$category->id)->select('id','title','slug','image','updated_at','author_id')->with('comments','author')->latest()->paginate(10);
         $popular=Post::where('category_id',$category->id)->select('id','title','slug','image','updated_at')->withCount('comments')->orderBy('comments_count','desc')->limit(5)->get();
         if($category){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'data'=>[
                    'category'=>$category,
                    'posts'=>$post,
                    'popular'=>$popular
                ]
            ],200);
         }
         else{
            return response()->json([
                'success'=>false,
                'status'=>404,
                'message'=>'No category found'
            ],200);
         }
}
}
