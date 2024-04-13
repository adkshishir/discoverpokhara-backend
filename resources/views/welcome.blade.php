@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
<div class="card mt-4 w-100 flex justify-content-center ">
    <div class="card-header w-100 mx-auto h3">All Collections</div>
    <div class="card-body">
        {{-- Themes --}}
        <x-adminlte-small-box class="small-box" title="{{$categoryCount}}" text="Categories" icon="fas fa-eye text-dark"
            theme="teal" url="{{route('categories.index')}}" url-text=" View details" />
        {{-- Themes --}}
        <x-adminlte-small-box class="small-box" title="{{$tagsCount}}" text="Tags" icon="fas fa-eye text-dark"
            theme="success" url="{{route('tags.index')}}" url-text="View details" />
        {{-- Themes --}}
        <x-adminlte-small-box class="small-box" title="{{$postCount}}" text="Posts" icon="fas fa-eye text-dark" theme="info"
            url="{{route('posts.index')}}" url-text="View details" />
        {{-- Themems --}}
        <x-adminlte-small-box class="small-box" title="{{$viewCount}}" text="Views" icon="fas fa-eye text-dark"
            theme="danger" url="{{route('posts.index')}}" url-text="View details" id="sbThemems" />
        {{-- Themems --}}
        <x-adminlte-small-box class="small-box" title="{{$commentCount}}" text="Comments" icon="fas fa-eye text-dark"
            theme="warning" url="{{route('posts.index')}}" url-text="View details" id="sbUpdatable" />
    </div>
</div>

</div>
    </div>
</div>
@endsection

@section('css')
<style>
    .card-body {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 2rem!important;
        justify-content: center;
        align-items: center;
        align-content: center;
        width: 100%;
    }
    .small-box{
   width: 22%;
    }
</style>

@endsection