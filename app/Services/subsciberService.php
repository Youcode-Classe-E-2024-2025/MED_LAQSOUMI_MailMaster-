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
     * Subscribe a user
     *
     * @param array $data
     * @return array
     */
    public function subscribe(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $subscriber = $this->subscriberRepository->subscribe($data);

        return [
            'message' => 'Subscription successful',
            'subscriber' => $subscriber,
        ];
    }

    /**
     * Unsubscribe a user
     *
     * @param array $data
     * @return array
     */
    public function unsubscribe(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|exists:subscribers,email',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $subscriber = $this->subscriberRepository->unsubscribe($data['email']);

        return [
            'message' => 'Unsubscription successful',
            'subscriber' => $subscriber,
        ];
    }

    /**
     * Get all subscribers
     *
     * @return array
     */

    public function getAllSubscribers()
    {
        $subscribers = $this->subscriberRepository->getAllSubscribers();

        return [
            'subscribers' => $subscribers,
        ];
    }
    /**
     * Get a subscriber by email
     *
     * @param array $data
     * @return array
     */
    public function getSubscriberByEmail(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email|exists:subscribers,email',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $subscriber = $this->subscriberRepository->findSubscriberByEmail($data['email']);

        return [
            'subscriber' => $subscriber,
        ];
    }

}
