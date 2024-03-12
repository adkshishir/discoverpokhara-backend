<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index(){
   try{
    
    $categories = Category::select('id', 'name', 'slug')
    ->with(['posts' => function ($query) {
        $query->select( 'title', 'slug','image')->get();
    }])
    ->latest()->get();
    if($categories){
        return response()->json([
            'success'=>true,
            'status'=>200,
            'categories'=>$categories
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
         $category=Category::where('slug',$slug)->with(['posts'=>function($query){
             $query->select('title','slug','author_id','image');
         }])->get()->first();
         if($category){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'data'=>[
                    'category'=>$category,
                   
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
