<?php

namespace App\Services;

use App\Repositories\SubscriberRepository;

class SubscriberService
{
    protected $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Get all subscribers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSubscribers()
    {
        return $this->subscriberRepository->getAllSubscribers();
    }

    /**
     * Find a subscriber by ID.
     *
     * @param int $id
     * @return \App\Models\Subscriber|null
     */
    public function findSubscriberById($id)
    {
        return $this->subscriberRepository->getSubscriberById($id);
    }
    /**
     * Create a new subscriber.
     *
     * @param array $data
     * @return \App\Models\Subscriber
     */
    public function createSubscriber(array $data)
    {
        return $this->subscriberRepository->createSubscriber($data);
    }

    /**
     * Update an existing subscriber.
     *
     * @param \App\Models\Subscriber $subscriber
     * @param array $data
     * @return \App\Models\Subscriber
     */

    public function updateSubscriber($subscriber, array $data)

    {
        return $this->subscriberRepository->updateSubscriber($subscriber, $data);
    }

    /**
     * Delete a subscriber.
     *
     * @param \App\Models\Subscriber $subscriber
     * @return bool|null
     */

    public function deleteSubscriber($subscriber)
    {
        return $this->subscriberRepository->deleteSubscriber($subscriber);
    }

    /**
     * Get subscribers by newsletter ID.
     *
     * @param int $newsletterId
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getSubscribersByNewsletterId($newsletterId)
    {
        return $this->subscriberRepository->getSubscribersByNewsletterId($newsletterId);
    }

    /**
     * Get subscribers by email
     *
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubscribersByEmail($email)
    {
        return $this->subscriberRepository->getSubscribersByEmail($email);
    }
}
