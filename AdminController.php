<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userpost;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Mail;




class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {

        //     if (Auth::user()->role_id == 1) {
        //         return view('adminaccess.posts');
        //     }
        // } else {
        //     return redirect()->back()->with('message', 'Incorrect Email or Password');
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Userpost::query()->orderby(Userpost::raw('case when status= "Pending" then 1 when status= "Rejected" then 2 when status= "Approved" then 3 end'))
            ->active()
            ->latest()
            ->paginate(5);

        return view('adminaccess.posts', compact('posts'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        $post = Userpost::find($id);
        $post->status = $post->status = Userpost::STATUS_APPROVED;
        $post->save();


        // $useremail = User::where('id', $post->user->id);
        $user = $post->user->email;
        $data = [
            'body' => 'your post was approved and you can see it in feeds'
        ];

        Mail::send('adminaccess.approvedemail', $data, function ($message) use ($user) {
            $message->to($user);
            $message->subject('Post Approved Mail');
        });
        return redirect('post')->with('success', 'Status Approved Succesfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $id)
    {
        $post = Userpost::find($id);
        $post->status = $post->status = Userpost::STATUS_REJECTED;
        $post->save();

        $user = $post->user->email;

        Mail::send('adminaccess.rejectedemail', ['data' => Userpost::STATUS_REJECTED], function ($message) use ($user) {
            $message->to($user);
            $message->subject('Email Verification Mail');
        });

        return redirect('post')->with('success', 'Status Rejected Succesfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function users()
    {

        $users = User::get();

        return view('adminaccess.users', compact('users'));
    }


    public function unbanned($id)
    {
        $user = User::find($id);
        $user->active = $user->active = User::STATUS_ACTIVE;
        $user->save();

        return redirect('users')->with('success', 'User is unbanned Successfully');
    }
    public function banned($id)
    {
        $user = User::find($id);

        if ($user->role_id == User::ROLE_ADMIN) {
            return back()->with('error', 'You Can not Ban Admin');
        } else
            $user->active = $user->active = User::STATUS_BANNED;
        $user->save();
        return redirect('users')->with('success', 'User Banned Succesfully');
    }
}
