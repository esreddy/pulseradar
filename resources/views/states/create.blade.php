<!-- resources/views/states/create.blade.php -->
@extends('layout')
@section('title','Add New State')

@section('content')
<div class="container">
    <h1>Add New State</h1>
    <form action="{{ route('states.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">State Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter state name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add State</button>
    </form>
</div>
@endsection
