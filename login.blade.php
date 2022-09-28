@extends('layouts.layout')


@section('content')


    <div class="container col-5 bg-light mt-5">

        <h2>User login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('message'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <form method="post" action="li" class="p-3">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name='email' id="useremail" placeholder="name">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="userpassword" name='password'
                    placeholder="*****">
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button> &nbsp;&nbsp;&nbsp;&nbsp; Doesn't have account?<a
                href="/"> SignUp</a>
        </form>

    </div>
@endsection
