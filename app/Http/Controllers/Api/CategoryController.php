<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
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
    
    $categories = Category::select('id','name','slug','image')->with(['posts','tags'])->get();
    $tempCategorys=[];
    foreach($categories as $key=>$category){
        $tempCategorys[$key]['id']=$category->id;
        $tempCategorys[$key]['name']=$category->name;
        $tempCategorys[$key]['slug']=$category->slug;
        $tempCategorys[$key]['image']=$category->getMedia('categories')?->first()?->getFullUrl();
        $tempCategorys[$key]['tag']=$category->tags->select('id','name','slug')->first();
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
         $category=Category::where('slug',$slug)->with(['seo','posts'])->get()->first();
         $posts=Post::where('category_id',$category->id)->select('id','title','slug','image','updated_at','author_id')->with(['comments','author','tags'=>function($q){$q->select('name','slug')->first();}])->latest()->paginate(10);
         $popular=Post::where('category_id',$category->id)->select('id','title','slug','image','updated_at')->with(['tags'=>function($q){$q->select('name','slug')->first();}])->withCount('comments')->orderBy('comments_count','desc')->limit(5)->get();
         $postsWithImage=Helper::dataWithImage($posts,'posts');
         $popularWithImage=Helper::dataWithImage($popular,'posts');
         if($category){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'data'=>[
                    'image'=>$category->getMedia('categories')->first()?->getFullUrl(),
                    'category'=>$category,
                    'posts'=>$postsWithImage,
                    'popular'=>$popularWithImage,
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
