<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $comment;
    public $post_id;
    public $date;
    public $time;
    public $ownerPost;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notifyData = [])
    {
        $this->user_id = $notifyData['user_id'];
        $this->comment = $notifyData['comment'];
        $this->post_id = $notifyData['post_id'];
        $this->ownerPost = $notifyData['ownerPost'];
        $this->date = date("Y M d", strtotime(Carbon::now()));
        $this->time = date("h:i A", strtotime(Carbon::now()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('new-notification');
    }

    public function broadcastAs()
    {
        return 'new-notification';
    }

}