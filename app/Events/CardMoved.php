<?php

namespace App\Events;

use App\Models\RetroData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardMoved implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $card;
    public $fromColumnId;
    public $toColumnId;

    public function __construct(RetroData $card, int $fromColumnId, int $toColumnId)
    {
        $this->card = $card;
        $this->fromColumnId = $fromColumnId;
        $this->toColumnId = $toColumnId;
    }

    public function broadcastOn()
    {
        return new Channel('retro-' . $this->toColumnId);
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
        return 'card-moved';
    }
}
