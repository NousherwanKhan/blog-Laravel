@extends('homenavbar.homenav')

@section('user')
    <!-- Add Modal -->
    <div class="modal fade" id="AddTableModal" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">

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
            <!-- Add Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='Addpost' action="post" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group error">
                            <label>Post</label>
                            {{-- <small id="name_error" class="form-text text-danger"></small> --}}
                            <input type="text" class="form-control has-error" id="post" name="post">
                            {{-- <span class="text-danger"></span> --}}
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Write something about Picture" id="description" name="description"
                                style="height: 100px"></textarea>
                            <label for="description" name="description">Description</label>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


    <div class="container">

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <h2 class="justify-content-between">
                            {{ Auth::user()->name }}'s Wall
                            <!-- Trigger the modal with a button -->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-lg float-left" data-toggle="modal"
                                data-target="#AddTableModal">Add Post</button>
                        </h2>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Post</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($posts as $post)
                                            <tr>
                                                <td>{{ $post->id }}</td>
                                                <td>{{ $post->user->name }}</td>
                                                <td>{{ $post->post }}</td>
                                                <td> <img src="{{ asset('public/images/post/'.$post->image)}}" alt=""
                                                        width="50"></td>
                                                <td>{{ $post->description }}</td>
                                                <td>
                                                    @if ($post->status == \App\Models\Userpost::STATUS_PENDING)
                                                        <span class="label label-primary">Pending</span>
                                                    @elseif($post->status == \App\Models\Userpost::STATUS_APPROVED)
                                                        <span class="label label-success">Approved</span>
                                                    @else($post->status == \App\Models\Userpost::STATUS_REJECED)
                                                        <span class="label label-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($post->status !== \App\Models\Userpost::STATUS_REJECTED)
                                                        <a href="{{ url('edit/' . $post->id) }}"
                                                            class="edit btn btn-primary btn-sm editItem">Edit</a>
                                                    @else
                                                        <a href="" class="edit btn btn-primary btn-sm editItem"
                                                            disabled>Edit</a>
                                                    @endif
                                                    <a
                                                        href="{{ url('delete/' . $post->id) }}"class="btn btn-danger btn-sm deleteItem">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endsection
