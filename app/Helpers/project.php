<?php

use App\Models\Project;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use App\Models\User;

if (!function_exists('getHoursAndMinutesFromTime')) {
    function getHoursAndMinutesFromTime(int $time): string
    {
        $str = '';
        $hrs = floor($time / 60);
        $min = $time % 60;

        $str = strlen($hrs) == 1 ? $str . '0' : $str;
        $str = $str . $hrs . ':';

        $str = strlen($min) == 1 ? $str . '0' : $str;
        $str = $str . $min;

        return $str;
    }
}

if (!function_exists('getTimeFromHoursAndMinutes')) {
    function getTimeFromHoursAndMinutes($user_hours = 0, $user_minutes = 0): int
    {
        return ($user_hours * 60) + $user_minutes;
    }
}

if (!function_exists('setEmployeesOfProject')) {
    function setEmployeesOfProject(int $project_id, array $employee_ids): void
    {
        // del all initial employees if thers any
        deleteAllEmployeesOfProject($project_id);

        foreach ($employee_ids as $employee_id) {
            ProjectEmployee::create([
                'project_id' => $project_id,
                'employee_id' => $employee_id
            ]);
        }
    }
}

if (!function_exists('getInputtedEmployees')) {
    function getInputtedEmployees(Request $request): array
    {
        $MAX_EMPLOYEES = 100;
        $inputedEmployees = [];
        for ($i = 0; $i < $MAX_EMPLOYEES; $i++) {
            if ($request->input('employee' . $i) == null) {
                continue;
            }

            if (in_array($request->input('employee' . $i), $inputedEmployees)) {
                continue;
            }

            array_push($inputedEmployees, $request->input('employee' . $i));
        }

        return $inputedEmployees;
    }
}

if (!function_exists('deleteAllEmployeesOfProject')) {
    function deleteAllEmployeesOfProject(int $project_id): void
    {
        ProjectEmployee::where('project_id', $project_id)
            ->delete();
    }
}

// if (!function_exists('getUserNameFromId')) {
//     function getUserNameFromId(int $user_id): string
//     {
//         return User::where('id', $user_id)->first()->name;
//     }
// }

// if (!function_exists('getProjectTitleFromId')) {
//     function getProjectTitleFromId(int $project_id): string
//     {
//         return Project::where('id', $project_id)->first()->title;
//     }
// }
