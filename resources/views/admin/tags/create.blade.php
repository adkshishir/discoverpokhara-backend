@extends('layouts.app')

@section('title', 'Create Tags')
@section('header', 'Tags')
@section('content')

<div class="container h-full w-full">
    <div class="container pt-5 rounded ">
        <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data" action="{{ route('tags.store') }}" method="POST">
            @csrf
            <h3>SEO</h3>`
            <div class="row">
                   <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_title') }}" name="meta_title" label="Meta Title" placeholder="Enter meta title" fgroup-class=""
                    disable-feedback />
                  @if($errors->has('meta_title'))
                    <div class="text-danger">{{ $errors->first('meta_title') }}</div>
                  @endif
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_description') }}" name="meta_description" label="Meta Description" placeholder="Enter meta description" fgroup-class=""
                        disable-feedback />
                        @if($errors->has('meta_description'))
                        <div class="text-danger">{{ $errors->first('meta_description') }}</div>
                      @endif
                </div>
                <div class="col-md-12">
                    <x-adminlte-input value="{{ old('meta_keywords') }}" name="meta_keywords" label="Meta Keywords" placeholder="Enter meta keywords" fgroup-class=""
                        disable-feedback />
                        @if($errors->has('meta_keywords'))
                        <div class="text-danger">{{ $errors->first('meta_keywords') }}</div>
                      @endif
                </div>
                <div class="col-md-12">
                  @php
              
                  @endphp
                 <x-adminlte-textarea name="schema" rows="7" label="Schema" placeholder="Write Schema..."/>
                      @if($errors->has('schema'))
                      <div class="text-danger">{{ $errors->first('schema') }}</div>
                    @endif

                </div>
            </div>
            <div class="row">
                  <div class="col-md-6">
                    <x-adminlte-input value="{{ old('name') }}" name="name" label="Name" placeholder="Enter name" fgroup-class=""
                    disable-feedback />
                    @if($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                  @endif
                  </div>
                  <div class="col-md-6">
                    <x-adminlte-input value="{{ old('slug') }}" name="slug" label="Slug" placeholder="Slug..." fgroup-class=""
                    disable-feedback />
                    @if($errors->has('slug'))
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                  @endif
                  </div>
                  <div class="col-md-12">
                      {{-- With label and feedback disabled --}}
                      <div>
                        <label for="formFile" class="form-label">Large file input example</label>
                        <input class="form-control form-control-lg" id="formFileLg" type="file" value="{{ old('image') }}" name="image">
                      </div>
                {{-- <x-adminlte-input-file value="{{ old('image') }}" class="w-full" fgroup-class="" name="image" label="Upload file" placeholder="Choose a file..." disable-feedback /> --}}
                    @if($errors->has('image'))
                    <div class="text-danger">{{ $errors->first('image') }}</div>
                  @endif
                  </div>

            </div>
           
            <x-adminlte-button  class="btn-flat  mt-4" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save " />
        </form>
    </div>
</div>
@endsection