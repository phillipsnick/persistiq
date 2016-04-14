<?php

namespace PersistIQ\Resource;

use PersistIQ\Exception\MaxEntryException;

class Campaigns extends AbstractResource
{
    //TODO: we need to add next support!
    public function all($next = null)
    {
        return $this->get('campaigns');
    }

    /**
     * Limit of 10 leads per request
     *
     * @param string $campaignId
     * @param array $leadIds
     * @return array
     * @throws MaxEntryException
     */
    public function addLeads($campaignId, array $leadIds)
    {
        if (count($leadIds) > 10) {
            throw new MaxEntryException(count($leadIds));
        }

        $ids = ['leads' => []];

        foreach ($leadIds as $leadId) {
            $ids['leads'][] = ['id' => $leadId];
        }

        return $this->post('campaigns/' . $campaignId . '/leads', $ids);
    }
}
