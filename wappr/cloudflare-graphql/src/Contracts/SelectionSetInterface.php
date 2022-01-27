<?php

namespace Wappr\Cloudflare\Contracts;

// Maybe change this to QuerySelectionSetInterface, and create another one that
// is ArraySelectionSetInterface that returns an array for the datasets that
// return an array instead of a query. This way, we can set the return type.
interface SelectionSetInterface
{
    public function getSelection();
}
