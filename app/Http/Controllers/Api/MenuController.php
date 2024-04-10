<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class MenuController extends Controller
{
    public function index(){
        $posts =Category::select('id','name','slug')->with(['posts'=>function($query){
            $query->select('title','slug','author_id','image');
        }])->get();
        if($posts){
            return response()->json([
                'success'=>true,
                'status'=>200,
                'data'=>$posts
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
