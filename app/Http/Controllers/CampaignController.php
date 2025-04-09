<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Campaigns",
 *     description="API Endpoints for Campaign Management"
 * )
 */
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
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Campaign"))
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
     *         @OA\JsonContent(
     *             required={"name", "newsletter_id"},
     *             @OA\Property(property="name", type="string", example="Spring Sale Campaign"),
     *             @OA\Property(property="description", type="string", example="Campaign for the spring season sales"),
     *             @OA\Property(property="newsletter_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campaign created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
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
     *     path="/api/campaigns/{id}",
     *     summary="Get a specific campaign by ID",
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
     *         @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
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
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Payload to update the campaign",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="The name of the campaign",
     *                 example="New Campaign Name"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="The description of the campaign",
     *                 example="This is an updated description for the campaign."
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="The status of the campaign",
     *                 example="active"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Campaign updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Updated campaign details"
     *             )
     *         )
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
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid request payload"
     *             )
     *         )
     *     )
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
     */
    public function destroy(int $id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json(null, 204);
    }

    /**
     * Get all campaigns by newsletter ID.
     */
    public function getCampaignsByNewsletterId(int $newsletterId)
    {
        $campaigns = Campaign::where('newsletter_id', $newsletterId)->get();

        return response()->json($campaigns);
    }

    /**
     * Get campaigns by cpmaigns ID.
     */

    public function getCampaignsById(int $id)
    {
        $campaigns = Campaign::where('id', $id)->get();

        return response()->json($campaigns);
    }
}
