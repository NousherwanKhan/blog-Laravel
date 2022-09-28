@extends('homenavbar.homenav')

@section('admin')
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

                        <h1>Admin's Pannel</h1>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>Post</th>
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
                                                <td>
                                                    @if ($post->status ==  \App\Models\Userpost::STATUS_PENDING)
                                                        <span class="label label-primary">Pending</span>
                                                    @elseif($post->status ==  \App\Models\Userpost::STATUS_APPROVED)
                                                        <span class="label label-success">Approved</span>
                                                    @else($post->status ==  \App\Models\Userpost::STATUS_REJECTED)
                                                        <span class="label label-danger">Rejected</span>
                                                    @endif

                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($post->status ==  \App\Models\Userpost::STATUS_PENDING)
                                                        <a href="{{ url('accept/' . $post->id) }}"
                                                            class="edit btn btn-info btn-sm editItem">Accept</a>
                                                        <a
                                                            href="{{ url('reject/' . $post->id) }}"class="btn btn-danger btn-sm deleteItem">Reject</a>
                                                    @else
                                                        <a href="{{ url('accept/' . $post->id) }}"
                                                            class="edit btn btn-info btn-sm editItem" disabled>Accept</a>
                                                        <a href="{{ url('reject/' . $post->id) }}"class="btn btn-danger btn-sm deleteItem"
                                                            disabled>Reject</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{-- <div class="container mb-2 col-3"> {!! $posts->appends(\Request::except('links'))->render() !!} </div> --}}
                                    
                                </table>
                                {{ $posts->links() }}
                            @endsection
