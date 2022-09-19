<?php

namespace App\Models;

use App\Jobs\SendEmailJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'estimated_time',
        'customer_id'
    ];

    protected static function booted()
    {
        static::deleted(function (Project $project) {
            // delete project employees
            ProjectEmployee::where('project_id', $project->id)
                ->delete();

            // delete project estimated time adds
            EmployeeEstimatedTime::where('project_id', $project->id)
                ->delete();

            // delete requests
            Request::where('project_id', $project->id)
                ->delete();

            // send notification to customer
            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 2
            ]);

            SendEmailJob::dispatch(
                $project->customer->email,
                [
                    'name' => 'One of your projects was deleted',
                    'dob' => now()
                ]
            );
        });

        static::created(function (Project $project) {
            $attributes = request()->all();
            $attributes['project_id'] = $project->id;
            EmployeeEstimatedTime::create($attributes);

            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 0
            ]);

            SendEmailJob::dispatch(
                $project->customer->email,
                [
                    'name' => 'A new project was created for you',
                    'dob' => now()
                ]
            );
        });

        static::updated(function (Project $project) {
            if (request()->get('estimated_time') != $project->estimated_time) {
                $attributes = request()->all();
                $attributes['project_id'] = $project->id;
                EmployeeEstimatedTime::create($attributes);
            }

            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 1
            ]);

            SendEmailJob::dispatch(
                $project->customer->email,
                [
                    'name' => 'One of your projects was updated',
                    'dob' => now()
                ]
            );
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['query'] ?? false,
            fn ($query, $search) =>
            $query->where('title', 'like', '%' . $search . '%')
        );

        $query->when(
            $filters['limit'] ?? false,
            fn ($query, $limit) =>
            $query->limit($limit)
        );

        $query->when(
            $filters['customer'] ?? false,
            fn ($query, $customer) =>
            $query->where('customer_id', $customer)
        );

        $query->when(
            $filters['timeRegistered'] ?? false,
            fn ($query, $days) =>
            $query->where('created_at', '>=', now()->addDays(-$days))
        );
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    protected function estimatedTime(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value + getTimeFromHoursAndMinutes(
                request()->post('hours'),
                request()->post('minutes')
            )
        );
    }

    public function getProjectsOfCustomer(
        int $customerId,
        array $filters
    ): Collection {
        return $this->where('customer_id', $customerId)
            ->when($filters ?? false, function ($query, $filters) {
                $this->scopeFilter($query, $filters);
            })
            ->get();
    }

    public function getById(
        $id,
        bool $withCustomer = false
    ): Project {
        return $this->where('id', $id)
            ->when($withCustomer, function ($query) {
                $query->with('customer');
            })
            ->first();
    }
}
