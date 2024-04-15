@extends('layouts.app')

@section('title', 'Tags')
@section('header', 'Tag')

@section('content')
@if(isset($success)!='')
<div class="alert alert-success" role="alert">
    {{ $success }}
</div>
@endif
@if(isset($error)!='')
<div class="alert alert-danger" role="alert">
    {{ $error }}
</div>
@endif

{{-- Setup data for datatables --}}
@php
$heads = [
'ID',
'Title',
['label' => 'Slug', 'width' => 40],
['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

function getActionButtons($id)
{
$btnEdit = '<a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-id="' . $id . '">
    <i class="fa fa-lg fa-fw fa-pen"></i>
</a>';

$btnDelete ='<form action="' . route('tags.destroy', $id) . '" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="' . csrf_token() . '">
    <button type="submit" onclick="return confirm(\'Are you sure?\')"
        class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-id="' . $id . '">
        <i class="fa fa-lg fa-fw fa-trash"></i>
</button>
</form>';

$btnDetails = '<a class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" data-id="' . $id . '">
    <i class="fa fa-lg fa-fw fa-eye"></i>
</a>';

return $btnEdit . ' ' . $btnDelete . ' ' . $btnDetails;
}


$data=[];
foreach ($tags as $key => $tag) {
$data[] = [
$tag->id,
$tag->title,
$tag->slug,
"<div class=\"d-flex\">" . getActionButtons($tag->id) . "</div>",
];
}

$config = [
'data' => $data,
'order' => [[1, 'asc']],
'columns' => [null, null, null, ['orderable' => false]],
];
@endphp

<div class="p-2 container">
    {{-- <div class="card p-2 h3">All Tags</div> --}}
    {{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable class="card rounded p-2" id="table1" :heads="$heads">
    @foreach($config['data'] as $row)
    <tr>
        @foreach($row as $cell)
        <td>{!! $cell !!}</td>
        @endforeach
    </tr>
    @endforeach
</x-adminlte-datatable>
</div>

{{-- Compressed with style options / fill data using the plugin config
<x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config" striped hoverable bordered
    compressed /> --}}

@endsection

@push('js')
<script>
  
    $(document).ready(function() {
    // Handle edit button click
    $(document).on('click', 'a[title="Edit"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
location.href = '/tags/' + id + '/edit';
    });
});
</script>

@endpush