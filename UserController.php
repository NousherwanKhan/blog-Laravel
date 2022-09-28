<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Userpost;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreRequest;
use App\Models\LikeDislike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->active) {

                if (Auth::user()->role_id ==  User::ROLE_USER) {

                    return redirect('wall');
                } else if (Auth::user()->role_id == User::ROLE_ADMIN) {

                    return redirect('post');
                }
            } else {
                return redirect()->back()->with('message', 'User is banned');
            }
        } else {
            return redirect()->back()->with('message', 'Incorrect Email or Password');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $posts = Userpost::where('user_id', Auth::user()->id)->get();
        return view('useraccess.home', compact('posts'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        $post = new Userpost;

        $post->post = $request->input('post');
        $post->description = $request->input('description');
        $post->user_id = Auth::user()->id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/images/post/', $filename);
            $post->image = $filename;
        }
        $post->save();

        return redirect('wall')->with('success', 'Post Create Successfully');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Userpost::where('user_id', Auth::user()->id)->find($id);

        if (!$post || $post->status == Userpost::STATUS_REJECTED || $post->status == null) {
            return redirect('wall');
        }
        // else if ($post->status == null) {

        //     return redirect('wall');
        // } 
        else {
            return view('useraccess.edit', compact('post'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $post = Userpost::where('user_id', Auth::user()->id)->find($id);

        $post->post = $request->post;
        $post->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'public/images/post/' . $post->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/images/post/', $filename);
            $post->image = $filename;
        }
        $post->save();

        return redirect('wall')
            ->with('success', 'Post Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Userpost::where('user_id', Auth::user()->id)->find($id);
        if ($post) {
            $path = 'public/images/post/' . $post->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $post->delete();
            return redirect('wall')
                ->with('success', 'Post Deleted successfully.');
        }
    }

    public function comment(Request $request)
    {
        // $posts = Userpost::find($id);

        $comments = new Comment;

        $comments->userpost_id = $request->get('post_id');
        $comments->user_id = Auth::user()->id;
        $comments->comment = $request->input('comment');
        $comments->save();

        return redirect()->route('viewpost', ['id' => $request->get('post_id')]);
    }


    public function like(Request $request)
    {
        // $post =  Userpost::find($id);

        $match = ['user_id' => Auth::user()->id, 'userpost_id' => $request->get('userpost_id')];

        $like = LikeDislike::where($match)->first();

        if (empty($like)) {
            $like = new LikeDislike();
            $like->userpost_id = $request->get('userpost_id');
            $like->user_id = Auth::user()->id;
            $like->like = $request->input('like');
            $like->save();

            return redirect()->route('viewpost', ['id' => $request->get('userpost_id')]);
            
        } elseif (!empty($like)) {
            $like->delete();
            $like = new LikeDislike();
            $like->userpost_id = $request->get('userpost_id');
            $like->user_id = Auth::user()->id;
            $like->like = $request->input('like');
            $like->save();

            return redirect()->route('viewpost', ['id' => $request->get('userpost_id')]);
        }
    }

    public function dislike(Request $request)
    {

        $match = ['user_id' => Auth::user()->id, 'userpost_id' => $request->get('userpost_id')];

        $like = LikeDislike::where($match)->first();
        
        if (empty($like)) {
            $like = new LikeDislike();
            $like->userpost_id = $request->get('userpost_id');
            $like->user_id = Auth::user()->id;
            $like->dislike = $request->input('dislike');
            $like->save();

            return redirect()->route('viewpost', ['id' => $request->get('userpost_id')]);

        } 
        elseif (!empty($like)) {
            $like->delete();
            $like = new LikeDislike();
            $like->userpost_id = $request->get('userpost_id');
            $like->user_id = Auth::user()->id;
            $like->dislike = $request->input('dislike');
            $like->save();

            return redirect()->route('viewpost', ['id' => $request->get('userpost_id')]);
        }
    }
}
