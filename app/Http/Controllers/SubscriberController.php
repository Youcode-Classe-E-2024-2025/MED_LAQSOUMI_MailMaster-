<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    protected $subscriberService;
    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->subscriberService->getAllSubscribers();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'newsletter_id' => 'required|exists:newsletters,id',
        ]);

        $subscriber = $this->subscriberService->createSubscriber($request->all());

        return response()->json($subscriber, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subscriber = $this->subscriberService->findSubscriberById($id);

        if (!$subscriber) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }

        return response()->json($subscriber);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'newsletter_id' => 'required|exists:newsletters,id',
        ]);

        $subscriber = $this->subscriberService->updateSubscriber($id, $request->all());

        if (!$subscriber) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }

        return response()->json($subscriber);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscriber = $this->subscriberService->findSubscriberById($id);

        if (!$subscriber) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }

        $this->subscriberService->deleteSubscriber($id);

        return response()->json(['message' => 'Subscriber deleted successfully']);
    }
    /**
     * Find a subscriber by email
     *
     * @param string $email
     * @return JsonResponse
     */
    public function findSubscriberByEmail(string $email)
    {
        try {
            $subscriber = $this->subscriberService->getSubscribersByEmail($email);
            return response()->json($subscriber, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    /**
     * Find a subscriber by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function findSubscriberById(int $id)
    {
        try {
            $subscriber = $this->subscriberService->findSubscriberById($id);
            return response()->json($subscriber, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
