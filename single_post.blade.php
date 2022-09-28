@extends('layouts.layout')


@section('content')
    <a class="btn btn-light" href="{{ route('/') }}" role="button">Back</a>


    <div class="container col-8">
        @if ($message = Session::get('message'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <p class="fs-4"> Post by {{ $posts->user->name }}</p>
        <h1 class="mt-5"> {{ $posts->post }} </h1><br>
        <p class="fs-3">{{ $posts->description }}</p>

        <img src="{{ asset('public/images/post/' . $posts->image) }}" alt="{{ $posts->user->name }}'s.img" width="50%">

        <div class="mt-3 d-flex flex-row">

            <form action="{{ url('like/' .$posts->id) }}" method="post" class="p-1">
                @csrf

                <input type="hidden" name="userpost_id" value="{{ $posts->id }}">
                <button class="btn btn-info" type="submit" name="like" value="1">Like {{ $posts->likes_count }}</button>
            </form>


            <form action="{{ url('dislike/' .$posts->id) }}" method="post" class="p-1">
                @csrf
                <input type="hidden" name="userpost_id" value="{{ $posts->id }}">
                <button class="btn btn-danger" type="submit" name="dislike" value="1">Dislike {{ $posts->dislikes_count }}</button>
            </form>

        </div>
        <div class="mt-3 justify-content-end">
            <p>Post Views </p>
        </div>

        <form action="{{ route('comment') }}" method="post">
            @csrf

            <div class="form-floating mt-3 col-6 ">
                <textarea class="form-control" name="comment" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Type a Comment</label>
                <input type="hidden" name="post_id" value="{{ $posts->id }}" />

            </div>

            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
        <div class="mt-4 mb-5 bg-info card">
            <h3 class="card-head">Comments</h3>
            <div class="card body">
                @foreach ($comments as $comments)
                    <div class="border bg-light">
                        <h5>{{ $comments->users->name }}</h5>
                        <p>{{ $comments->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
