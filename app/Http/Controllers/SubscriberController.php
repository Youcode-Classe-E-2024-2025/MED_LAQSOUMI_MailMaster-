<?php

namespace App\Http\Controllers;

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
     *
     * @OA\Get(
     *    path="/api/subscribers",
     *   tags={"Subscribers"},
     *   summary="Get all subscribers",
     *  description="Returns a list of all subscribers",
     *   @OA\Response(
     *        response=200,
     *       description="Successful operation",
     *      @OA\JsonContent(
     *           type="array",
     *          @OA\Items(
     *              type="object",
     *             @OA\Property(property="id", type="integer"),
     *            @OA\Property(property="email", type="string"),
     *           @OA\Property(property="newsletter_id", type="integer"),
     *          @OA\Property(property="created_at", type="string", format="date-time"),
     *         @OA\Property(property="updated_at", type="string", format="date-time")
     *           )
     *       )
     *   )
     * )
     */

    public function index()
    {
        return $this->subscriberService->getAllSubscribers();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/subscribers",
     *     summary="Create new subscriber",
     *     description="Creates a new subscriber and returns the created object",
     *     operationId="createSubscriber",
     *     tags={"Subscribers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "newsletter_id"},
     *             @OA\Property(property="email", type="email", example="admin@admin.com"),
     *            @OA\Property(property="newsletter_id", type="integer", example=1)
     *         )
     *     ),
     *    @OA\Response(
     *        response=201,
     *       description="Subscriber created successfully",
     *       @OA\JsonContent(
     *           type="object",
     *          @OA\Property(property="id", type="integer"),
     *          @OA\Property(property="email", type="string"),
     *         @OA\Property(property="newsletter_id", type="integer"),
     *        @OA\Property(property="created_at", type="string", format="date-time"),
     *       @OA\Property(property="updated_at", type="string", format="date-time")
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *        response=422,
     *       description="Validation error",
     *      @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="The email field is required.")
     *      )
     *   )
     * )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
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
     *
     * @OA\Get(
     *    path="/api/subscribers/{id}",
     *   summary="Get subscriber by ID",
     *   description="Returns a single subscriber by ID",
     *   operationId="getSubscriberById",
     *  tags={"Subscribers"},
     *    @OA\Parameter(
     *        name="id",
     *       in="path",
     *       required=true,
     *      description="ID of subscriber to return",
     *      @OA\Schema(type="string")
     *    ),
     *   @OA\Response(
     *       response=200,
     *      description="Successful operation",
     *     @OA\JsonContent(
     *          type="object",
     *         @OA\Property(property="id", type="integer"),
     *        @OA\Property(property="email", type="string"),
     *       @OA\Property(property="newsletter_id", type="integer"),
     *      @OA\Property(property="created_at", type="string", format="date-time"),
     *     @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *   ),
     *  @OA\Response(
     *      response=404,
     *     description="Subscriber not found",
     *    @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Subscriber not found")
     *       )
     *  )
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
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
     *
     * @OA\Put(
     *    path="/api/subscribers/{id}",
     *   summary="Update subscriber",
     *  description="Updates an existing subscriber",
     *  operationId="updateSubscriber",
     *  tags={"Subscribers"},
     *   @OA\Parameter(
     *       name="id",
     *      in="path",
     *      required=true,
     *     description="ID of subscriber to update",
     *     @OA\Schema(type="string")
     *    ),
     *  @OA\RequestBody(
     *       required=true,
     *      @OA\JsonContent(
     *          required={"email", "newsletter_id"},
     *            @OA\Property(property="email", type="email", example="admin@admin.com"),
     *            @OA\Property(property="newsletter_id", type="integer", example=1)
     *        )
     *   ),
     *  @OA\Response(
     *       response=200,
     *      description="Subscriber updated successfully",
     *     @OA\JsonContent(
     *          type="object",
     *         @OA\Property(property="id", type="integer"),
     *        @OA\Property(property="email", type="string"),
     *       @OA\Property(property="newsletter_id", type="integer"),
     *      @OA\Property(property="created_at", type="string", format="date-time"),
     *     @OA\Property(property="updated_at", type="string", format="date-time")
     *        )
     *  ),
     * @OA\Response(
     *      response=422,
     *     description="Validation error",
     *    @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="The email field is required.")
     *      )
     *   ),
     * @OA\Response(
     *     response=404,
     *    description="Subscriber not found",
     *   @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Subscriber not found")
     *     )
     * )
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
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
     *
     * @OA\Delete(
     *     path="/api/subscribers/{id}",
     *     summary="Delete subscriber",
     *     description="Deletes a subscriber",
     *     operationId="deleteSubscriber",
     *     tags={"Subscribers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of subscriber to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Subscriber deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Subscriber deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Subscriber not found"
     *     )
     * )
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
     *
     * @OA\Get(
     *     path="/api/subscribers/email/{email}",
     *     summary="Find subscribers by email",
     *     description="Returns subscribers matching the email",
     *     operationId="findSubscriberByEmail",
     *     tags={"Subscribers"},
     *    @OA\Parameter(
     *        name="email",
     *       in="path",
     *      required=true,
     *      description="Email of subscriber to return",
     *     @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *        response=200,
     *       description="Successful operation",
     *      @OA\JsonContent(
     *           type="array",
     *          @OA\Items(
     *              type="object",
     *             @OA\Property(property="id", type="integer"),
     *            @OA\Property(property="email", type="string"),
     *           @OA\Property(property="newsletter_id", type="integer"),
     *          @OA\Property(property="created_at", type="string", format="date-time"),
     *         @OA\Property(property="updated_at", type="string", format="date-time")
     *          )
     *      )
     *   ),
     *  @OA\Response(
     *       response=422,
     *      description="Error finding subscriber",
     *     @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Error finding subscriber")
     *        )
     *  )
     * )
     */
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
     *
     * @OA\Get(
     *     path="/api/subscribers/id/{id}",
     *     summary="Find subscriber by ID (alternative endpoint)",
     *     description="Returns a single subscriber by ID",
     *     operationId="findSubscriberById",
     *     tags={"Subscribers"},
     *    @OA\Parameter(
     *       name="id",
     *      in="path",
     *     required=true,
     *     description="ID of subscriber to return",
     *    @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *       response=200,
     *      description="Successful operation",
     *     @OA\JsonContent(
     *          type="object",
     *        @OA\Property(property="id", type="integer"),
     *       @OA\Property(property="email", type="string"),
     *      @OA\Property(property="newsletter_id", type="integer"),
     *     @OA\Property(property="created_at", type="string", format="date-time"),
     *    @OA\Property(property="updated_at", type="string", format="date-time")
     *        )
     *  ),
     * @OA\Response(
     *      response=422,
     *     description="Error finding subscriber",
     *    @OA\JsonContent(
     *         @OA\Property(property="error", type="string", example="Error finding subscriber")
     *       )
     *  )
     * )
     */
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

