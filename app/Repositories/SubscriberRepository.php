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
     * Get a subscriber by ID.
     *
     * @param int $id
     * @return \App\Models\Subscriber|null
     */
    public function getSubscriberById($id)
    {
        return Subscriber::find($id);
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
    /**
     * Get subscribers by newsletter ID.
     *
     * @param int $newsletterId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubscribersByNewsletterId($newsletterId)
    {
        return Subscriber::where('newsletter_id', $newsletterId)->get();
    }

    /**
     * Get subscribers by email.
     *
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubscribersByEmail($email)
    {
        return Subscriber::where('email', $email)->get();
    }

    /**
     * Get subscribers by name.
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getSubscribersByName($name)
    {
        return Subscriber::where('name', 'like', '%' . $name . '%')->get();
    }

}
