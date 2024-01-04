<!-- resources/views/states/create.blade.php -->
@extends('layout')
@section('title','Create New Assembly')

@section('content')
<div class="container">
    <h1>Create New Assembly</h1>
    <!-- Form to create a new assembly -->
    <form action="{{ route('assemblies.store') }}" method="POST">
        @csrf
        <div>
            <label for="stateId">State:</label>
            <select name="stateId" id="stateId">
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>
        <button type="submit">Create Assembly</button>
    </form>
</div>
@endsection
