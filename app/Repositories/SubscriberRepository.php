<?php

namespace App\Repositories;

use App\Models\Subscriber;

class SubscriberRepository
{
    /**
     * Get all subscribers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSubscribers()
    {
        return Subscriber::all();
    }

    /**
     * Find a subscriber by Email
     *
     * @param string $email
     * @return \App\Models\Subscriber|null
     */
    public function findSubscriberByEmail($email)
    {
        return Subscriber::where('email', $email)->first();
    }

    /**
     * Create a new subscriber.
     *
     * @param array $data
     * @return \App\Models\Subscriber
     */
    public function createSubscriber(array $data)
    {
        return Subscriber::create($data);
    }

    /**
     * Update an existing subscriber.
     *
     * @param \App\Models\Subscriber $subscriber
     * @param array $data
     * @return \App\Models\Subscriber
     */
    public function updateSubscriber(Subscriber $subscriber, array $data)
    {
        $subscriber->update($data);
        return $subscriber;
    }

    /**
     * Delete a subscriber.
     *
     * @param \App\Models\Subscriber $subscriber
     * @return bool|null
     */
    public function deleteSubscriber(Subscriber $subscriber)
    {
        return $subscriber->delete();
    }
}
