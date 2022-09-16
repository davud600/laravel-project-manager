<?php

namespace App\Repositories;

use Illuminate\Contracts\View\View;

interface RepositoryInterface
{
    static public function dashboard(array $filters): View;
}
