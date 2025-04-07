<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Services\subscriberService;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    protected $subscriberService;
    public function __construct(subscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    /**
     * Subscribe a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */


    public function subscribe(Request $request)
    {
        $data = $request->only(['email']);

        try {
            $response = $this->subscriberService->subscribe($data);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Unsubscribe a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function unsubscribe(Request $request)
    {
        $data = $request->only(['email']);

        try {
            $response = $this->subscriberService->unsubscribe($data);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }


    /**
     * Get all subscribers
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getAllSubscribers()
    {
        try {
            $response = $this->subscriberService->getAllSubscribers();
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Get a subscriber by email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getSubscriberByEmail(Request $request)
    {
        $data = $request->only(['email']);

        try {
            $response = $this->subscriberService->getSubscriberByEmail($data);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
