<?php

namespace App\Helpers;
class Helper{

    public static function dataWithImage($data,string $imageCollecion){
      $tempData=[];
        foreach($data as $key => $value){
            $tempData[$key]['image']= $value->getMedia($imageCollecion)->first()?->getFullUrl();
            $tempData[$key]['data']=$value->toArray();
            unset($tempData[$key]['data']['media']);
        
        }
        return $tempData;
    }
    public static function nameAndSlug($data){
        $tempData=[];
        foreach($data as $key => $value){
            $tempData[$key]['name']= $value->name;
            $tempData[$key]['slug']= $value->slug;
        }
        return $tempData;
    }
}