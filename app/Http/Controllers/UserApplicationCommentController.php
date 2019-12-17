<?php

namespace App\Http\Controllers;

use App\UserApplication;
use App\UserApplicationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApplicationCommentController extends Controller
{
    public function applicationComments(UserApplication $application)
    {
        $comments = UserApplicationComment::with([
            'userApplication',
            'user'
        ])->where('user_application_id',$application->id)
            ->paginate(10);
//        return  json_encode($comments);
        return view('admin.applicationComments', compact('comments'))
            ->with(['application'=>$application]);
    }


    public function store(Request $request, UserApplication $userApplication)
    {
        $comments = new UserApplicationComment();
        $comments->comment = $request->comment;
        $comments->user_id = Auth::id();
        $comments->user_application_id = $userApplication->id;
        $comments->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UserApplicationComment $userApplicationComment
     * @return \Illuminate\Http\Response
     */
    public function show(UserApplicationComment $userApplicationComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\UserApplicationComment $userApplicationComment
     * @return \Illuminate\Http\Response
     */
    public function edit(UserApplicationComment $userApplicationComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UserApplicationComment $userApplicationComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserApplicationComment $userApplicationComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserApplicationComment $userApplicationComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserApplicationComment $userApplicationComment)
    {
        //
    }
}
