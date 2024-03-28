@extends('layouts.app')

@section('title', 'Categories')
@section('header', 'Category')

@section('content')
@if(isset($success)!='')
<div class="alert alert-success" role="alert">
    {{ $success }}
</div>
@endif
{{-- Setup data for datatables --}}
@php
$heads = [
'ID',
'Title',
// ['label' => 'Image', 'width' => 40],
'slug',
['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

function getActionButtons($id)
{
$btnEdit = '<a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-id="' . $id . '">
    <i class="fa fa-lg fa-fw fa-pen"></i>
</a>';

$btnDelete = '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" data-id="' . $id . '">
    <i class="fa fa-lg fa-fw fa-trash"></i>
</a>';

$btnDetails = '<a class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" data-id="' . $id . '">
    <i class="fa fa-lg fa-fw fa-eye"></i>
</a>';

return $btnEdit . ' ' . $btnDelete . ' ' . $btnDetails;
}
$data=[];
foreach ($posts as $key => $post) {
$data[] = [
$post->id,
$post->title,
$post->slug,
"<div class=\"d-flex\">" . getActionButtons($post->id) . "</div>",


];

}

$config = [
'data'=>$data,
'order' => [[1, 'asc']],
'columns' => [null, null, null, ['orderable' => false]],
];

@endphp

{{-- Minimal example / fill data using the component slot --}}
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($config['data'] as $row)
    <tr>
        @foreach($row as $cell)
        <td>{!! $cell !!}</td>
        @endforeach
    </tr>
    @endforeach
</x-adminlte-datatable>

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
        location.href = '/admin/posts/' + id + '/edit';
        
    });

    // Handle delete button click
    $(document).on('click', 'a[title="Delete"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        // Perform delete action for the record with the provided ID

    });

    // Handle details button click
    $(document).on('click', 'a[title="Details"]', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        // Perform details action for the record with the provided ID
        console.log('View details for record with ID:', id);
        location.href = '/admin/posts/' + id + '/show';

    });
});
</script>
@endpush