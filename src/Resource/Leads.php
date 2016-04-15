<?php

namespace PersistIQ\Resource;

use PersistIQ\Exception\MaxEntryException;

class Leads extends AbstractResource
{
    /**
     * @param null|string $next
     * @return array
     */
    public function all($next = null)
    {
        $url = 'leads';
        $fullUrl = false;

        if ($next) {
            $url = $next;
            $fullUrl = true;
        }

        return $this->get($url, [], $fullUrl);

    }

    /**
     * @param string $leadId
     * @return array
     */
    public function view($leadId)
    {
        return $this->get('leads/' . $leadId);
    }

    /**
     * Create up to 10 leads at a time
     *
     * @param array $leads
     * @param string|null $creatorId - PersistIQ user ID
     * @param string $dup - Defaults to skip
     * @return array
     * @throws MaxEntryException
     */
    public function create(array $leads, $creatorId = null, $dup = 'skip')
    {
        if (count($leads) > 10) {
            throw new MaxEntryException(count($leads));
        }

        $request = [
            'dup' => $dup,
            'leads' => $leads
        ];

        if ($creatorId) {
            $request['creator_id'] = $creatorId;
        }

        return $this->post('leads', $request);
    }

    // TODO:
    public function update($leadId)
    {
        //TODO:
    }
}
