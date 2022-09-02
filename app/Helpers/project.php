<?php

use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\User;

if (!function_exists('getHoursAndMinutesFromTime')) {
    function getHoursAndMinutesFromTime($time)
    {
        $str = '';
        $hrs = floor($time / 60);
        $min = $time % 60;

        if (strlen($hrs) == 1) {
            $str = $str . '0';
        }
        $str = $str . $hrs . ':';

        if (strlen($min) == 1) {
            $str = $str . '0';
        }
        $str = $str . $min;

        return $str;
    }
}

if (!function_exists('getTimeFromHoursAndMinutes')) {
    function getTimeFromHoursAndMinutes($user_hours, $user_minutes)
    {
        $user_hours = $user_hours ? $user_hours : 0;
        $user_minutes = $user_minutes ? $user_minutes : 0;

        return ($user_hours * 60) + $user_minutes;
    }
}

if (!function_exists('setEmployeesOfProject')) {
    function setEmployeesOfProject($project_id, $employee_ids)
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
    function getInputtedEmployees($request)
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
    function deleteAllEmployeesOfProject($project_id)
    {
        ProjectEmployee::where('project_id', $project_id)
            ->delete();
    }
}

if (!function_exists('getUserNameFromId')) {
    function getUserNameFromId($user_id)
    {
        return User::where('id', $user_id)->first()->name;
    }
}

if (!function_exists('getProjectTitleFromId')) {
    function getProjectTitleFromId($project_id)
    {
        return Project::where('id', $project_id)->first()->title;
    }
}
