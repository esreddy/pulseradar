<!-- resources/views/states/edit.blade.php -->

@extends('layout')
@section('title','Edit State')
@section('content')

<div class="container">
    <h1>Edit State</h1>
    <form action="{{ route('states.update', $state->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">State Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $state->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update State</button>
    </form>
</div>
@endsection
