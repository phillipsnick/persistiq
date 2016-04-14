<?php

namespace PersistIQ\Resource;

class Users extends AbstractResource
{
    /** @return array */
    public function all()
    {
        //TODO: does this need next support?
        return $this->get('users');
    }
}
