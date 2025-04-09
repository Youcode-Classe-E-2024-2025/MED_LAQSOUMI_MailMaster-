<?php

namespace App\Services;
use App\Repositories\CampaignRepository;

class CampaignService
{

    protected $campaignRepository;
    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }
    /**
     * Get all campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCampaigns()
    {
        return $this->campaignRepository->getAllCampaigns();
    }


    /**
     * Find a campaign by ID.
     *
     * @param int $id
     * @return \App\Models\Campaign|null
     */
    public function getCampaignById($id)
    {
        return $this->campaignRepository->getCampaignById($id);
    }
    /**
     * Create a new campaign.
     *
     * @param array $data
     * @return \App\Models\Campaign
     */
    public function createCampaign(array $data)
    {
        return $this->campaignRepository->createCampaign($data);
    }
    /**
     * Update an existing campaign.
     *
     * @param \App\Models\Campaign $campaign
     * @param array $data
     * @return \App\Models\Campaign
     */
    public function updateCampaign($campaign, array $data)
    {
        return $this->campaignRepository->updateCampaign($campaign, $data);
    }

    /**
     * Delete a campaign.
     *
     * @param \App\Models\Campaign $campaign
     * @return bool|null
     */

    public function deleteCampaign($campaign)
    {
        return $this->campaignRepository->deleteCampaign($campaign);
    }
    /**
     * Get all campaigns by newsletter ID.
     *
     * @param int $newsletterId
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getCampaignsByNewsletterId($newsletterId)
    {
        return $this->campaignRepository->getCampaignsByNewsletterId($newsletterId);
    }

}
