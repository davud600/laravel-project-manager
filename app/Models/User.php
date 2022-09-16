<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(
            fn (User $user) =>
            // Assign role
            $user->assignRole(
                match ($user->role) {
                    1 => 'Admin',
                    2 => 'Employee',
                    3 => 'Customer'
                }
            )
        );
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['query'] ?? false,
            fn ($query, $search) =>
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
        );

        $query->when(
            $filters['limit'] ?? false,
            fn ($query, $limit) =>
            $query->limit($limit)
        );

        $query->when(
            $filters['role'] ?? false,
            fn ($query, $role) =>
            $query->where('role', $role)
        );

        $query->when(
            $filters['timeRegistered'] ?? false,
            fn ($query, $days) =>
            $query->where('created_at', '>=', now()->addDays(-$days))
        );
    }

    public function getById($id): User
    {
        return $this->where('id', $id)
            ->first();
    }

    public function getEmployees(): Collection
    {
        return $this->where('role', 1)
            ->get();
    }

    public function getCustomers(): Collection
    {
        return $this->where('role', 0)
            ->get();
    }
}
