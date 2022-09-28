@extends('homenavbar.homenav')

@section('user')

    <div class="container col-6 bg-light p-4">
        <h1>Edit Post</h1>
        <form id='editPost' action="{{ url('update/'.$post->id) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="modal-body">

                <div class="form-group error">
                    <label>Post</label>
                    {{-- <small id="name_error" class="form-text text-danger"></small> --}}
                    <input type="text" class="form-control has-error" id="post" name="post" value="{{ $post->post }}">
                    {{-- <span class="text-danger"></span> --}}
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control"  placeholder="Write something about Picture" id="description" name="description"
                        style="height: 100px">{{ $post->description }}</textarea>
                    <label for="description" name="description">Description</label>
                </div>
                <div class="mb-3 form-floating">
                    <img src="\images\post\{{ $post->image }}" alt="img" width="50">
                    <input class="form-control mt-3" type="file" name="image">
                </div>
            </div>
            <div class=" modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        <a href="/wall" class="btn btn-secondary" role="button"> Close </a> 
    </div>
@endsection
