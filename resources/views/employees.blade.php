@extends('layout')
@section('title','Dashboard Page')
@section('content')

<div class="container">
<!-- Dropdown for selecting rows per page -->
<select id="rowsPerPage">
    <option value="10">10</option>
    <option value="25">25</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <!-- Add other options as needed -->
</select>
<p>Total Records: {{ $records->total() }}</p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Employee Id</th>
      <th scope="col">Name</th>
      <th scope="col">Mobile No.</th>
      <th scope="col">Role</th>
      <th scope="col">Parent</th>
      <th scope="col">Status</th>
      <th scope="col">Created Date</th>
      <th scope="col">Last Login Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<?php
$statusNames = [
    0 => 'Deactivate',
    1 => 'Activate',
    2 => 'Blocked',
    4 => 'Device Rest'
];
?>
@php $i = ($records->currentPage() - 1) * $records->perPage() + 1; @endphp
@foreach ($records as $record)

    <tr>
        <th scope="row">{{ $i++ }}</th>
        <td>{{ $record->id }}</td>
        <td>{{ $record->name }}</td>
        <td>{{ $record->mobileNumber }}</td>
        <td>{{ $record->role->name ?? 'No Role' }}</td>
        <td>
            @if ($record->parent)
                {{ $record->parent->name }}
            @else
                No Parent
            @endif
        </td>
        <td>
        @if (array_key_exists($record->status, $statusNames))
                {{ $statusNames[$record->status] }}
            @else
                Role Undefined
        @endif
        </td>
        <td>{{ $record->createdDate }}</td>
        <td>{{ $record->loginDate }}</td>
        <td><a href="edit_record/{{ $record->id }}" ><button class="btn btn-primary">Edit</button></a></td>
    </tr>
@endforeach

  </tbody>
</table>
{{ $records->links('pagination::bootstrap-5') }}
</div>
@endsection




