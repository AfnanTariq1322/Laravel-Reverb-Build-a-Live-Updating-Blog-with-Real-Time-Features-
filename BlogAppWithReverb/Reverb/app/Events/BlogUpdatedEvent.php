<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Blog;
class BlogUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $blog;
    /**
     * Create a new event instance.
     */
    public function __construct(Blog $blog)
    {
        $this->blog= $blog;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('blogs')
        ];
    }

    public function broadcastAs(): string
    {
        return  'blog.updated';
    }
    public function broadcastWith()
    {
        return   
        [
            'id' => $this->blog->id,
            
            'title' => $this->blog->title,
            
            'content' => $this->blog->content,
            'created_at' => $this->blog->created_at,
             'user'=>[
                'id'=> $this->blog->user->id,
                'name'=> $this->blog->user->name,
             ]   ,
        ];
    }
}
