@extends('layouts.layout')


@section('content')
    <div class="container-fluid">
        <h1 class="bg-light p-5">USERS POSTS</h1>

        <div class="container m-5 col-md-8">

            @foreach ($posts as $post)
                <h1 class="mt-5"> {{ $post->post }} </h1><br>
                <p class="fs-3">{{ $post->description }}</p>

                <img src="{{ asset('public/images/post/' . $post->image) }}" alt="{{ $post->user->name }}'s.img"
                    width="50%">
                    
{{--                     
                <div class="mt-3">
                    <a class="btn btn-info" href="" role="button">Like</a>
                    <a class="btn btn-danger" href="" role="button">Dislike</a>
                    <div class="float-end col-8">
                        <p>Post Views </p>
                    </div>
                </div> --}}
                <div>
                    <p>Posted by <b> <a href="#" class="text-decoration-none"> {{ $post->user->name }}</b> </a></p>
                </div>
                <div>
                    <p> Date Posted {{ $post->created_at }}</p>
                </div>
                <div>
                    <a href="{{ url('viewpost/' . $post->id) }}" class="">View Full Post</a>
                </div>
            @endforeach

        </div>

    </div>
@endsection
