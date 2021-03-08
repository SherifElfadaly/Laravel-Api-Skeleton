<?php

namespace App\Modules\Core\Listeners;

use App\Modules\Core\Utl\AppleSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppleExtendSocialite
{
    /**
     * Register the Provider.
     *
     * @param SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('apple', AppleSocialite::class);
    }
}
