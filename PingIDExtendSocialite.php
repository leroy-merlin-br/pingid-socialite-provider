<?php

namespace SocialiteProviders\PingID;

use SocialiteProviders\Manager\SocialiteWasCalled;

class PingIDExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('pingid', Provider::class);
    }
}
