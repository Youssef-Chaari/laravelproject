<?php

namespace App\Providers;

use App\Models\CarUsed;
use App\Models\ForumTopic;
use App\Models\ForumComment;
use App\Policies\CarUsedPolicy;
use App\Policies\ForumTopicPolicy;
use App\Policies\ForumCommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        CarUsed::class      => CarUsedPolicy::class,
        ForumTopic::class   => ForumTopicPolicy::class,
        ForumComment::class => ForumCommentPolicy::class,
    ];

    public function register(): void {}

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', fn ($user) => $user->isAdmin());
    }
}
