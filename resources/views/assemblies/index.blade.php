<!-- resources/views/assemblies/index.blade.php -->
@extends('layout')
@section('title','List of Assemblies')
@section('content')

<div class="container">
<h1>List of Assemblies</h1>
    <a href="{{ route('assemblies.create') }}" class="btn btn-primary mb-3">Add Assembliy</a>

    @if ($assemblies->isEmpty())
        <p>No Assemblies found</p>
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
                @foreach ($assemblies as $assembly)
                    <tr>
                        <td>{{ $assembly->id }}</td>
                        <td>{{ $assembly->name }}</td>
                        <td>
                            <a href="{{ route('assemblies.edit', $assembly->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('assemblies.destroy', $assembly->id) }}" method="POST" style="display: inline-block;">
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

