<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $text;
    public $id;
    public $for_user_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $for_user_id)
    {
        $this->text = $text;
        $this->for_user_id = $for_user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       // return new Channel('my-channel');
        return ['notification-channel_'.$this->for_user_id];
    }

    public function broadcastAs()
  {
      return 'my-event';
  }
}
