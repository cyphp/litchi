<?php

namespace Lychee\Support;

class PermissibleFile extends \SplFileInfo
{
    public function isReadWritePermitted(): bool
    {
        return true;
        // return $this->isReadable() && $this->isWritable();
    }
}
