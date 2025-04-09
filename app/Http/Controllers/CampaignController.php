<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/campaigns",
     *     summary="Get all campaigns",
     *     tags={"Campaigns"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="newsletter_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $campaigns = Campaign::all();
        return response()->json($campaigns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/campaigns",
     *     summary="Create a new campaign",
     *     tags={"Campaigns"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Campaign data",
     *         @OA\JsonContent(
     *             required={"name", "newsletter_id"},
     *             @OA\Property(property="name", type="string", example="New Campaign"),
     *             @OA\Property(property="description", type="string", example="This is a new campaign."),
     *             @OA\Property(property="newsletter_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="newsletter_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Validation error"),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="The name field is required.")),
     *                 @OA\Property(property="newsletter_id", type="array", @OA\Items(type="string", example="The selected newsletter id is invalid."))
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'newsletter_id' => 'required|integer|exists:newsletters,id',
        ]);

        $campaign = Campaign::create($request->all());

        return response()->json($campaign, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *    path="/api/campaigns/{id}",
     *   summary="Get a specific campaign",
     *   tags={"Campaigns"},
     *   @OA\Parameter(
     *        name="id",
     *       in="path",
     *       required=true,
     *      description="The ID of the campaign to retrieve",
     *      @OA\Schema(
     *           type="integer",
     *          example=1
     *      )
     *   ),
     *  @OA\Response(
     *       response=200,
     *      description="Campaign retrieved successfully",
     *      @OA\JsonContent(
     *           type="object",
     *          @OA\Property(property="id", type="integer"),
     *          @OA\Property(property="name", type="string"),
     *         @OA\Property(property="description", type="string"),
     *         @OA\Property(property="newsletter_id", type="integer"),
     *        @OA\Property(property="created_at", type="string", format="date-time"),
     *       @OA\Property(property="updated_at", type="string", format="date-time")
     *      )
     *  ),
     * @OA\Response(
     *      response=404,
     *     description="Campaign not found",
     *    @OA\JsonContent(
     *        type="object",
     *       @OA\Property(property="error", type="string", example="Campaign not found")
     *      )
     *   )
     * )
     */

    public function show(int $id)
    {
        $campaign = Campaign::findOrFail($id);

        return response()->json($campaign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/campaigns/{id}",
     *     summary="Update a specific campaign",
     *     tags={"Campaigns"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the campaign to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated campaign data",
     *         @OA\JsonContent(
     *             required={"name", "newsletter_id"},
     *             @OA\Property(property="name", type="string", example="Updated Campaign"),
     *             @OA\Property(property="description", type="string", example="This is an updated campaign."),
     *             @OA\Property(property="newsletter_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="newsletter_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     * )
     */

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'newsletter_id' => 'required|integer|exists:newsletters,id',
        ]);

        $campaign = Campaign::findOrFail($id);

        $campaign->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $campaign,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/campaigns/{id}",
     *     summary="Delete a specific campaign",
     *     tags={"Campaigns"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the campaign to delete",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Campaign deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Campaign not found"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json(null, 204);
    }

        /**
     * Get all campaigns by newsletter ID.
     *
     * @OA\Get(
     *     path="/api/newsletters/{newsletter_id}/campaigns",
     *     summary="Get campaigns by newsletter ID",
     *     operationId="getCampaignsByNewsletterId",
     *     tags={"Campaigns"},
     *     @OA\Parameter(
     *         name="newsletter_id",
     *         in="path",
     *         required=true,
     *         description="Newsletter ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="newsletter_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function getCampaignsByNewsletterId(int $newsletterId)
    {
        $campaigns = Campaign::where('newsletter_id', $newsletterId)->get();

        return response()->json($campaigns);
    }

    /**
     * Get campaign by campaign ID.
     *
     * @OA\Get(
     *     path="/api/campaigns/find/{id}",
     *     summary="Get campaign by ID (alternative endpoint)",
     *     operationId="getCampaignsById",
     *     tags={"Campaigns"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Campaign ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="newsletter_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function getCampaignsById(int $id)
    {
        $campaigns = Campaign::where('id', $id)->get();

        return response()->json($campaigns);
    }
}
