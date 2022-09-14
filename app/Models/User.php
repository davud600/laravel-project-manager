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
        static::created(function (User $user) {
            // Assign role
            $user->assignRole(
                match ($user->role) {
                    2 => 'Admin',
                    1 => 'Employee',
                    0 => 'Customer'
                }
            );
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['query'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('company', 'like', '%' . $search . '%');
        });
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

    public function getUsersByIds(array $userIds): Collection
    {
        return $this->where('id', $userIds)
            ->get();
    }
}
