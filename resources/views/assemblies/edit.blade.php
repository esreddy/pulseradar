<!-- resources/views/assemblies/edit.blade.php -->
@extends('layout')
@section('title','Edit Assembly')


@section('content')
<div class="container">
    <h1>Edit Assembly</h1>
    <!-- Form to edit an existing assembly -->
    <form action="{{ route('assemblies.update', $assembly->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="state_id">State:</label>
            <select name="state_id" id="state_id">
                @foreach($states as $state)
                    <option value="{{ $state->id }}" @if($state->id === $assembly->state_id) selected @endif>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $assembly->name }}">
        </div>
        <button type="submit">Update Assembly</button>
    </form>
<div class="container">
@endsection
