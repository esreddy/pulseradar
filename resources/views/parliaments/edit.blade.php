<!-- resources/views/parliaments/edit.blade.php -->
@extends('layout')
@section('title','Edit Parliament')


@section('content')
<div class="container">
    <h1>Edit Parliament</h1>
    <!-- Form to edit an existing assembly -->
    <form action="{{ route('parliaments.update', $parliament->id) }}" method="POST">
        @csrf
        @method('PUT')
        <?php //print_r($parliament); ?>
        <div>
            <label for="state_id">State:</label>
            <select name="state_id" id="state_id">
            @foreach($states as $state)
                <option value="{{ $state->id }}" @if(trim($state->id) == trim($parliament->stateId)) selected @endif >  {{ $state->name }} </option>
            @endforeach

            </select>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $parliament->name }}">
        </div>
        <button type="submit">Update Parliament</button>
    </form>
<div class="container">
@endsection
