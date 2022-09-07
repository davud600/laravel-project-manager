<?php

namespace App\Permissions;

class Permission
{
    public const LIST_USERS = 'list-users';
    public const CREATE_USERS = 'create-users';
    public const EDIT_USERS = 'edit-users';
    public const DELETE_USERS = 'delete-users';

    public const LIST_PROJECTS = 'list-projects';
    public const CREATE_PROJECTS = 'create-projects';
    public const EDIT_PROJECTS = 'edit-projects';
    public const DELETE_PROJECTS = 'delete-projects';
    public const ADD_TIME_TO_PROJECTS = 'add-time-to-projects';

    public const LIST_REQUESTS = 'list-requests';
    public const CREATE_REQUESTS = 'create-requests';
    public const EDIT_REQUESTS = 'edit-requests';
    public const DELETE_REQUESTS = 'delete-requests';
    public const CHANGE_STATUS_REQUESTS = 'change-status-requests';

    public const IMPORT_EXCEL_DATA = 'import-excel-data';
}
