<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Seo;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
    $tags=Tag::select('id','name','slug','category_id')->with(['category'=>function ($q){
        $q->select('id','name','slug');
    },
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
         $tag=Tag::where('slug',$slug)->select('id', 'name', 'slug')->with(['seo',])->get()->first();
         $posts=Post::whereHas('tags', function ($q) use ($tag) {
             $q->where('tag_id', $tag->id);

         })->with(['category'=>function($q){$q->select('id','name','slug');},'author'=>function($q){$q->select('id','name');}])->latest()->paginate(10);
            $postsWithImage=Helper::dataWithImage($posts,'posts');
         $popular=Post::whereHas('tags', function ($q) use ($tag) {
             $q->where('tag_id', $tag->id);

         })->with(['category'=>function($q){$q->select('id','name','slug');},'author'=>function($q){$q->select('id','name');}])->withCount('comments')->orderBy('comments_count','desc')->limit(5)->get();
         $popularWithImage=Helper::dataWithImage($popular,'posts');
         
        if($tag){
           return response()->json([
               'success'=>true,
               'status'=>200,
               'data'=>[
                   'tag'=>[
                    'image'=>$tag->getMedia('tags')->first()?->getFullUrl(),
                    'data'=>$tag
                   ] ,  
                   'posts'=>$postsWithImage,
                   'popular'=>$popularWithImage
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

