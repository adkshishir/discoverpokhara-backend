@extends('layouts.app')

@section('title', 'Create Category')
@section('header', 'Category')
@section('content')


<div class="container h-full w-full">
  <div class="container pt-5 rounded ">
    <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data" action="{{ route('tags.store') }}"
      method="POST">
      @csrf
      <h3>SEO</h3>
      <div class="row">
        <div class="col-md-6">
          <x-adminlte-input value="{{ old('meta_title') }}" name="meta_title" label="Meta Title"
            placeholder="Enter meta title" fgroup-class="">
            @if($errors->has('meta_title'))
            <div class="text-danger">{{ $errors->first('meta_title') }}</div>
            @endif
            <x-slot name='buttomsSlot'>
              @if($errors->has('meta_title'))
              <div id="meta_title_error" class="text-danger">{{ $errors->first('meta_title') }}</div>
              @endif
            </x-slot>
          </x-adminlte-input>

        </div>
        <div class="col-md-6">
          <x-adminlte-input value="{{ old('meta_description') }}" name="meta_description" label="Meta Description"
            placeholder="Enter meta description" fgroup-class="">
            <x-slot name='buttomsSlot'>
              @if($errors->has('meta_description'))
              <div id="meta_description_error" class="text-danger">{{ $errors->first('meta_description') }}</div>
              @endif
            </x-slot>
          </x-adminlte-input>
        </div>
        <div class="col-md-6">
          <x-adminlte-input value="{{ old('meta_keywords') }}" name="meta_keywords" label="Meta Keywords"
            placeholder="Enter meta keywords" fgroup-class="" />
        </div>
        <div class="col-md-6">
          <x-adminlte-input value="{{ old('cannonical_url') }}" name="cannonical_url" label="Cannonical Url"
            placeholder="Enter cannonical Url" fgroup-class="" />
        </div>
        <div class="col-md-12">
          <x-adminlte-textarea id="schema" name="schema" rows='7' class="form-control" label="schema"
            value="{{old('schema')}}" placeholder="Write Schema..." />
        </div>
        
      </div>
      <div class="row">
        <div class="col-md-6">
          <x-adminlte-input value="{{ old('name') }}" name="name" label="Name" placeholder="Enter name"
            fgroup-class="" />

        </div>
        <div class="col-md-6">
          <x-adminlte-input value="{{ old('slug') }}" name="slug" label="Slug" placeholder="Slug..." fgroup-class="" />

        </div>
        
        <div class="col-md-12">
          <x-adminlte-select name="category_id" label="Parent">
            @if(old('category_id'))
            <option value="{{old('category_id')}}">{{$categories[old('category_id')]}}</option>
            @endif
            @if($categories->count() > 0)
            @foreach ($categories as $key => $category)
            @if($key != old('category_id'))
            <option value="{{ $key }}">{{ $category }}</option>
            @endif
            @endforeach
            @endif
          </x-adminlte-select>
        </div>
        <div class="col-md-12">
          <x-adminlte-textarea id="description" name="description" rows="4" label="description"
            value="{{old('description')}}" placeholder="Write Schema..." />
          {{-- <textarea name="description" rows="4" label="description" value="{{old('description')}}"
            placeholder="Write Schema...">{{old('description')}}</textarea> --}}
        </div>

        <div class="col-md-12">
          <div class="container">
            <img id="imagepreview" class="w-25" src="{{old('image')}}" alt="">
          </div>

          <div>
            <label for="formFile" class="form-label mt-2">Upload </label>

            <input class="form-control form-control-md" id="image" type="file" placeholder="Choose a file..."
              value="{{ old('image') }}" name="image">
          </div>
        </div>


      </div>

      <x-adminlte-button class="btn-flat  mt-4" type="submit" label="Submit" theme="success"
        icon="fas fa-lg fa-save " />
    </form>
  </div>
</div>
@endsection

@push('js')
<script>
  $('#image').on('change', function() {
          if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#imagepreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
          }
        });
        // $(document).ready(function() {
        //   $('#schema').val(sessionStorage.getItem('schema'));
        //   $('#description').val(sessionStorage.getItem('description'));
        // });
        // $('#schema').on('input', function() {
        //   sessionStorage.setItem('schema', $(this).val());
        // });
        // $('#description').on('input', function() {
        //   sessionStorage.setItem('description', $(this).val());
        // });
</script>
@endpush