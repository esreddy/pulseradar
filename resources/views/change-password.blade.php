@extends('layout')
@section('title','Dashboard Page')
@section('content')

<div class="container">

    <h1>Change Password</h1>

    <div class="container">
        <div class="mt-5">
            @if($errors->any())
                <div class="col-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach

                </div>
            @endif
            @if(session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <form action="{{route('change.password.post')}}" method="POST" class="ms-auto me-auto mt-auto" style="width: 500px;">
            @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif
            @csrf

            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                <span class="text-danger">@error('current_password') {{ $message }} @enderror</span>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" placeholder="New Password">
                <span class="text-danger">@error('password') {{ $message }} @enderror</span>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                <span class="text-danger">@error('password_confirmation') {{ $message }} @enderror</span>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>












@endsection


