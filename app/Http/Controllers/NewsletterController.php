<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsletterService;

class NewsletterController extends Controller
{
    protected $newsletterService;
    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/newsletters",
     *     tags={"Newsletters"},
     *     summary="Get all newsletters",
     *     description="Returns a list of all newsletters",
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
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->newsletterService->getAllNewsletters();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/newsletters",
     *     tags={"Newsletters"},
     *     summary="Create new newsletter",
     *     description="Creates a new newsletter and returns the created object",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Monthly Updates"),
     *             @OA\Property(property="description", type="string", example="Newsletter with monthly updates")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Newsletter created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
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
            'description' => 'nullable|string|max:255',
        ]);

        $newsletter = $this->newsletterService->createNewsletter($request->all());

        return response()->json($newsletter, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/newsletters/{id}",
     *     tags={"Newsletters"},
     *     summary="Get newsletter by ID",
     *     description="Returns a single newsletter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of newsletter to return",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Newsletter not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $newsletter = $this->newsletterService->findNewsletterById($id);

        if (!$newsletter) {
            return response()->json(['message' => 'Newsletter not found'], 404);
        }

        return response()->json($newsletter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/newsletters/{id}",
     *     tags={"Newsletters"},
     *     summary="Update newsletter",
     *     description="Updates an existing newsletter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of newsletter to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Newsletter"),
     *             @OA\Property(property="description", type="string", example="Updated newsletter description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Newsletter not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $newsletter = $this->newsletterService->findNewsletterById($id);

        if (!$newsletter) {
            return response()->json(['message' => 'Newsletter not found'], 404);
        }

        $updatedNewsletter = $this->newsletterService->updateNewsletter($newsletter, $request->all());

        return response()->json($updatedNewsletter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/newsletters/{id}",
     *     tags={"Newsletters"},
     *     summary="Delete newsletter",
     *     description="Deletes a specified newsletter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of newsletter to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Newsletter deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Newsletter deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Newsletter not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $newsletter = $this->newsletterService->findNewsletterById($id);

        if (!$newsletter) {
            return response()->json(['message' => 'Newsletter not found'], 404);
        }

        $this->newsletterService->deleteNewsletter($newsletter);

        return response()->json(['message' => 'Newsletter deleted successfully']);
    }
}
