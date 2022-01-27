<?php

namespace Wappr\Cloudflare\Contracts;

interface DataSetInterface
{
    public function getDataSet();

    public function addSelectionSet(SelectionSetInterface $selectionSet);
}
