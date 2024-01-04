<!-- resources/views/states/index.blade.php -->


@extends('layout')
@section('title','List of States')
@section('content')

<div class="container">
<h1>List of States</h1>
    <a href="{{ route('states.create') }}" class="btn btn-primary mb-3">Add State</a>

    @if ($states->isEmpty())
        <p>No states found</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($states as $state)
                    <tr>
                        <td>{{ $state->id }}</td>
                        <td>{{ $state->name }}</td>
                        <td>
                            <a href="{{ route('states.edit', $state->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('states.destroy', $state->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

