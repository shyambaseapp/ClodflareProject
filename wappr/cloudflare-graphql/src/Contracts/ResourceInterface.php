<?php

namespace Wappr\Cloudflare\Contracts;

interface ResourceInterface
{
    public function getResource();

    public function addDataSet(DataSetInterface $dataset);
}
