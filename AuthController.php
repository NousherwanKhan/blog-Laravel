<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Userpost;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Models\LikeDislike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('signup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $posts = Userpost::where('status', 'Approved')->active()->get();

        return view('viewer.all_posts', compact('posts'));
    }

    public function viewpost($id)
    {

        $posts = Userpost::where('id', $id)->withCount('likes','dislikes')->first();
        $comments = Comment::where('userpost_id', $id)->get();
        
        $posts->update(['viewcount' => $posts->viewcount + 1]);
        $posts->save();
        
        return view('viewer.single_post', compact('posts' ,'comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignUpRequest $request)
    {
        // dd($request);
        $createUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => User::ROLE_USER
        ]);

        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $createUser->id, 
              'token' => $token
            ]);
  
        Mail::send('verificationemail', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
            });

        return redirect()->back()->with('success', 'Verification Email Sent to Your Email');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
  
      return redirect()->route('login')->with('message', $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy()
    {
        Auth::logout();
        return redirect('login');
    }
}
