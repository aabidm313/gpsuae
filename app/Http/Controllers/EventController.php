<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $events = Event::with('organizer')
            ->withCount('registrations')
            ->where('status', 'published')
            ->latest()
            ->paginate(15);

        return EventResource::collection($events);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = $request->user()->events()->create($request->validated());

        return response()->json([
            'message' => 'Event created successfully.',
            'event'   => new EventResource($event->load('organizer')),
        ], 201);
    }

    public function show(Event $event): JsonResponse
    {
        $event->load('organizer')->loadCount('registrations');

        return response()->json(new EventResource($event));
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        if ($request->user()->id !== $event->user_id) {
            return response()->json(['message' => 'Forbidden. You are not the organizer.'], 403);
        }

        $event->update($request->validated());

        return response()->json([
            'message' => 'Event updated successfully.',
            'event'   => new EventResource($event->load('organizer')),
        ]);
    }

    public function destroy(Request $request, Event $event): JsonResponse
    {
        if ($request->user()->id !== $event->user_id) {
            return response()->json(['message' => 'Forbidden. You are not the organizer.'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully.']);
    }
}
