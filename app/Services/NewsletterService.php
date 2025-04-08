<?php

namespace App\Services;
use App\Repositories\NewsletterRepository;

class NewsletterService
{
    protected $newsletterRepository;

    public function __construct(NewsletterRepository $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }

    /**
     * Get all newsletters.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllNewsletters()
    {
        return $this->newsletterRepository->getAllNewsletters();
    }

    /**
     * Find a newsletter by ID.
     *
     * @param int $id
     * @return \App\Models\Newsletter|null
     */
    public function findNewsletterById($id)
    {
        return $this->newsletterRepository->findNewsletterById($id);
    }
    /**
     * Create a new newsletter.
     *
     * @param array $data
     * @return \App\Models\Newsletter
     */
    public function createNewsletter(array $data)
    {
        return $this->newsletterRepository->createNewsletter($data);
    }
    /**
     * Update an existing newsletter.
     *
     * @param \App\Models\Newsletter $newsletter
     * @param array $data
     * @return \App\Models\Newsletter
     */
    public function updateNewsletter($newsletter, array $data)
    {
        return $this->newsletterRepository->updateNewsletter($newsletter, $data);
    }
    /**
     * Delete a newsletter.
     *
     * @param \App\Models\Newsletter $newsletter
     * @return bool|null
     */
    public function deleteNewsletter($newsletter)
    {
        return $this->newsletterRepository->deleteNewsletter($newsletter);
    }
}
