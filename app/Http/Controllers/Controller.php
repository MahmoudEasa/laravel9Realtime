<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Models\Comment;
use App\Models\post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function dashboard()
    {
        $posts = post::with('comments')->get();
        return view('dashboard', [
            'posts' => $posts,
        ]);
    }

    public function saveComment(Request $request)
    {
        $data = [
            "post_id" => $request -> post_id,
            "user_id" => Auth::id(),
            "comment" => $request -> post_content,
        ];

        Comment::create($data);

        $notifyData = [
            'user_id' => Auth::id(),
            'comment' => $request -> post_content,
            "post_id" => $request -> post_id,
        ];

        // Save notification in database table

        event(new NewNotification($notifyData));
        return redirect()->back()->with(['success' => 'Created.']);
    }
}