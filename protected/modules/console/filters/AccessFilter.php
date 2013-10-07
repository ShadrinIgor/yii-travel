<?php

class AccessFilter extends CFilter
{
    protected function filterCheckAccess($filterChain)
    {
        echo 'access';
        return true;
    }
}
