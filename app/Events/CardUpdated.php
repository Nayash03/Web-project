<?php

namespace App\Events;

use App\Models\RetroColumn;
use App\Models\RetroData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardAdded implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $card;
    public $columnId;

    public function __construct(RetroData $card, int $columnId)
    {
        $this->card = $card;
        $this->columnId = $columnId;
    }

    public function broadcastOn()
    {
        return new Channel('retro-' . $this->columnId);
    }

    public function broadcastWith()
    {
        return [
            'cardId' => $this->card->id,
            'name' => $this->card->name,
            'description' => $this->card->description,
            'position' => $this->card->position,
        ];
    }

    public function broadcastAs()
    {
        return 'card-added';
    }
}
