@extends('homenavbar.homenav')

@section('admin')

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-warning alert-block">
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
        </div>
    @endif

    <div class="container">
        <div class="col-10">
            <div class="card">
                <div class="card-header">

                    <h1>Admin's Pannel</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Active</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach ($users as $user)
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if ($user->active == \App\Models\User::STATUS_ACTIVE)
                                            <p class="btn btn-primary disabled"> Active </p>
                                        @elseif ($user->active == \App\Models\User::STATUS_BANNED)
                                            <p class="btn btn-danger disabled"> Banned </p>
                                    </td>
                                @endif
                                <td>
                                    <a href="{{ url('ban/' . $user->id) }}"class="btn btn-warning btn-sm">Ban</a>
                                    <a href="{{ url('unban/' . $user->id) }}"class="btn btn-info btn-sm">UnBan</a>
                                </td>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
