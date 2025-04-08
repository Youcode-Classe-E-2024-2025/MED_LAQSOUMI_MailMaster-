<?php

namespace App\Repositories;

use App\Models\Newsletter;

class NewsletterRepository
{
    /**
     * Get all newsletters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllNewsletters()
    {
        return Newsletter::all();
    }

    /**
     * Find a newsletter by ID.
     *
     * @param int $id
     * @return \App\Models\Newsletter|null
     */
    public function findNewsletterById($id)
    {
        return Newsletter::find($id);
    }

    /**
     * Create a new newsletter.
     *
     * @param array $data
     * @return \App\Models\Newsletter
     */
    public function createNewsletter(array $data)
    {
        return Newsletter::create($data);
    }

    /**
     * Update an existing newsletter.
     *
     * @param \App\Models\Newsletter $newsletter
     * @param array $data
     * @return \App\Models\Newsletter
     */
    public function updateNewsletter(Newsletter $newsletter, array $data)
    {
        $newsletter->update($data);
        return $newsletter;
    }

    /**
     * Delete a newsletter.
     *
     * @param \App\Models\Newsletter $newsletter
     * @return bool|null
     */
    public function deleteNewsletter(Newsletter $newsletter)
    {
        return $newsletter->delete();
    }
}
