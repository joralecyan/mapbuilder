<?php

namespace App\Events;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    protected int $id;
    /**
     * @var string
     */
    protected string $event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $event)
    {
        $this->id = $id;
        $this->event = $event;
    }

    /**
     * Emit Event
     * @return void
     */
    public function emit(): void
    {
        $version = new Version2X(config('socket.host') . ':' . config('socket.port'));
        $client = new Client($version);

        $client->initialize();
        $client->emit('to_server', [
            'room' => 'game_' . $this->id,
            'event' => $this->event
        ]);
        $client->close();
    }
}
