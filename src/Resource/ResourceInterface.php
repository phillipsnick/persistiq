<?php

namespace PersistIQ\Resource;

use PersistIQ\PersistIQ;

interface ResourceInterface
{
    /** @param PersistIQ $persistIQ */
    public function __construct(PersistIQ $persistIQ);
}
