@extends('layouts.layout')


@section('content')
    <div class="container col-5 bg-light mt-5">

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>-
        @endif

        <h2>Register User</h2>
        <form method="post" action="{{ route('postregister') }}" class="p-3">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control" name='name' id="username" placeholder="username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name='email' id="email" placeholder="name">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" name='password'
                    placeholder="*****">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
            &nbsp;&nbsp;&nbsp;&nbsp; Already a User
            <a href="login"> Login Here</a>
        </form>

    </div>
@endsection
