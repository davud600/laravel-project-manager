<?php

namespace App\Notifications;

class Notification
{
    public const type = [
        'New project was created',
        'Project was updated',
        'Project has been deleted',
        'You have been added to a project',
        'You have been removed from a project',
        'New request from customer',
        'Request was updated',
    ];
}
