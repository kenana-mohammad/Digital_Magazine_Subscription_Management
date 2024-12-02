<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Magazine;
use App\Models\Subscription;
use App\Policies\MagazinePolicy;
use App\Policies\SubscraptionPolicy;
use App\Policies\SubscriptionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Magazine::class => MagazinePolicy::class,
        Subscription::class=> SubscraptionPolicy::class

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
