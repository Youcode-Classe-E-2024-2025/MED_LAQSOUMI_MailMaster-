<?php

namespace App\Services;

use App\Repositories\SubscriberRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class subscriberService
{


    protected $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Register a new subscriber
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function register(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:subscribers',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $subscriber = $this->subscriberRepository->createSubscriber($data);

        return [
            'subscriber' => $subscriber,
        ];
    }

    /**
     * Get all subscribers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSubscribers()
    {
        return $this->subscriberRepository->getAllSubscribers();
    }

    /**
     * Find a subscriber by email
     *
     * @param string $email
     * @return \App\Models\Subscriber|null
     */

    public function findSubscriberByEmail($email)
    {
        return $this->subscriberRepository->findSubscriberByEmail($email);
    }


    /**
     * Update a subscriber
     *
     * @param \App\Models\Subscriber $subscriber
     * @param array $data
     * @return \App\Models\Subscriber
     */

    public function updateSubscriber($subscriber, array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'sometimes|required|string|email|max:255|unique:subscribers,email,' . $subscriber->id,
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->subscriberRepository->updateSubscriber($subscriber, $data);
    }


    /**
     * Delete a subscriber
     *
     * @param \App\Models\Subscriber $subscriber
     * @return bool|null
     */

    public function deleteSubscriber($subscriber)
    {
        return $this->subscriberRepository->deleteSubscriber($subscriber);
    }
}
