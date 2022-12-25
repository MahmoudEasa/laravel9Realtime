<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Models\Comment;
use App\Models\notification;
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
        $comment = $this->saveCommentInDatabaseTable($request);
        $ownerPost = $this->saveNotificationInDatabaseTable($request, $comment);
        $this->notificationRealtimeEvent($request, $ownerPost);
        return redirect()->back()->with(['success' => 'Created.']);
    }

    // Save Comment in database table
    protected function saveCommentInDatabaseTable($request){
        $data = [
            "post_id" => $request -> post_id,
            "user_id" => Auth::id(),
            "comment" => $request -> post_content,
        ];
        $createdComment = Comment::create($data);
        return $createdComment;
    }

    // Save Notification in database table
    protected function saveNotificationInDatabaseTable($request, $comment){
        $postId = post::find($request->post_id);
        $userId = User::find($postId->user_id)->id;

        $notificationTableData = [
            "post_id" => $request -> post_id,
            'comment_id' => $comment -> id,
            'user_id' => $userId,
        ];
        notification::create($notificationTableData);
        return $userId;
    }

    // Notification realtime event
    protected function notificationRealtimeEvent($request, $ownerPost){
        $notifyData = [
            'user_id' => Auth::id(),
            'comment' => $request -> post_content,
            "post_id" => $request -> post_id,
            "ownerPost" => $ownerPost,
        ];
        event(new NewNotification($notifyData));
    }

}