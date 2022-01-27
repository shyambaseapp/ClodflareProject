<?php

namespace Wappr\Cloudflare\SelectionSets;

abstract class AbstractSelectionSet
{
    public function __construct($selectionSet = [])
    {
        if ($selectionSet) {
            $this->selectionSet = $selectionSet;
        }
    }
}
