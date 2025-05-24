<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Group;
use App\Models\Message;

class GroupMessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $group;

    public function __construct(Group $group, Message $message)
    {
        $this->group = $group;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('group.' . $this->group->id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'sender_id' => $this->message->sender_id,
                'sender' => [
                    'id' => $this->message->sender->id,
                    'name' => $this->message->sender->name,
                    'profile_picture' => $this->message->sender->profile_picture,
                ],
                'content' => $this->message->content,
                'image' => $this->message->image,
                'created_at' => $this->message->created_at->toDateTimeString(),
            ],
            'group' => [
                'id' => $this->group->id,
                'name' => $this->group->name,
            ],
        ];
    }
}
