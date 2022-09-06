<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeActivityExport;
use App\Exports\ProjectsExport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelDataController extends Controller
{
    public function importEmployeeActivity()
    {
        return Excel::download(new EmployeeActivityExport, 'employee-activity.xlsx');
    }

    public function importUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function importProjects()
    {
        return Excel::download(new ProjectsExport, 'projects.xlsx');
    }
}
