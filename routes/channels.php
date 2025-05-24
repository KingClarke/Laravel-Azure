<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('group.{groupId}', function ($user, $groupId) {
    // Only allow users who are in the group
    return $user->groups->contains($groupId);
});
