<?php

namespace Wishters\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WishtersUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
