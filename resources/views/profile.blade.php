@extends('layout')
@section('title','Profile Page')
@section('content')

<div class="container">
    <h1>Profile Page</h1>
    <h1>{{ $data->name }}</h1>
</div>
@endsection
