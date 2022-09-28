@extends('layouts.bootstrap')

@section('navbar')
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 pt-3" href="{{ route('/') }}">NewFeeds</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li>
                        <a class="nav-link  text-decoration-none" href="{{ route('wall') }}">Wall</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post') }}">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users') }}">Users</a>
                    </li>
            </div>
            <a class="btn btn-primary" href="{{ route('logout') }}" role="button">logout</a>
        </div>
    </nav>

    @yield('admin')
    @yield('user')
@endsection
