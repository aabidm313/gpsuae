<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParticipantResource;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function register(Request $request, Event $event): JsonResponse
    {
        if ($event->status !== 'published') {
            return response()->json(['message' => 'This event is not open for registration.'], 422);
        }

        $existing = EventRegistration::where('event_id', $event->id)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existing) {
            if ($existing->status === 'registered') {
                return response()->json(['message' => 'You are already registered for this event.'], 422);
            }

            if ($event->isFull()) {
                return response()->json(['message' => 'This event has reached its maximum capacity.'], 422);
            }

            $existing->update(['status' => 'registered']);

            return response()->json(['message' => 'Registration reinstated successfully.']);
        }

        if ($event->isFull()) {
            return response()->json(['message' => 'This event has reached its maximum capacity.'], 422);
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'user_id'  => $request->user()->id,
            'status'   => 'registered',
        ]);

        return response()->json(['message' => 'Successfully registered for the event.'], 201);
    }

    public function unregister(Request $request, Event $event): JsonResponse
    {
        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', $request->user()->id)
            ->where('status', 'registered')
            ->first();

        if (! $registration) {
            return response()->json(['message' => 'You are not registered for this event.'], 404);
        }

        $registration->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Registration cancelled successfully.']);
    }

    public function index(Request $request, Event $event): JsonResponse
    {
        if ($request->user()->id !== $event->user_id) {
            return response()->json(['message' => 'Forbidden. Only the organizer can view participants.'], 403);
        }

        $participants = $event->participants()
            ->wherePivot('status', 'registered')
            ->get();

        return response()->json([
            'event'        => $event->title,
            'total'        => $participants->count(),
            'participants' => ParticipantResource::collection($participants),
        ]);
    }
}
