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
     */
    public function index()
    {
        return $this->newsletterService->getAllNewsletters();
    }

    /**
     * Store a newly created resource in storage.
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
