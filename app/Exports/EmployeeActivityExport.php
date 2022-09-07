<?php

namespace App\Exports;

use App\Models\EmployeeEstimatedTime;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeActivityExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employeeActivity = EmployeeEstimatedTime::with(['employee', 'project'])->get();

        foreach ($employeeActivity as $activity) {
            $activity->employee_id = $activity->employee->name;
            $activity->project_id = $activity->project->title;

            // $activity->employee_id = getUserNameFromId($activity->employee_id);
            // $activity->project_id = getProjectTitleFromId($activity->project_id);
        }

        return $employeeActivity;
    }
}
