<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'description'      => $this->description,
            'location'         => $this->location,
            'start_datetime'   => $this->start_datetime,
            'end_datetime'     => $this->end_datetime,
            'max_participants' => $this->max_participants,
            'status'           => $this->status,
            'organizer'        => new UserResource($this->whenLoaded('organizer')),
            'participants_count' => $this->whenCounted('registrations'),
            'created_at'       => $this->created_at,
        ];
    }
}
