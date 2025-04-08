<?php

namespace App\Repositories;

use App\Models\Campaign;

class CampaignRepository
{
    protected $model;

    public function __construct(Campaign $model)
    {
        $this->model = $model;
    }

    public function getAllCampaigns()
    {
        return $this->model->all();
    }

    public function getCampaignById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function createCampaign(array $data)
    {
        return $this->model->create($data);
    }

    public function updateCampaign($id, array $data)
    {
        $campaign = $this->getCampaignById($id);
        $campaign->update($data);
        return $campaign;
    }
    public function deleteCampaign($id)
    {
        $campaign = $this->getCampaignById($id);
        return $campaign->delete();
    }
    public function getCampaignsByNewsletterId($newsletterId)
    {
        return $this->model->where('newsletter_id', $newsletterId)->get();
    }
}
