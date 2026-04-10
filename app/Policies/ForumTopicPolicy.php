<?php

namespace App\Policies;

use App\Models\ForumTopic;
use App\Models\User;

class ForumTopicPolicy
{
    public function delete(User $user, ForumTopic $topic): bool
    {
        return $user->isAdmin() || $user->id === $topic->user_id;
    }
}
