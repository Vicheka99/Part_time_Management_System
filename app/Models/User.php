<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public const TABLE_NAME     = 'users';
    public const ID             = 'id';
    public const FIRST_NAME     = 'first_name';
    public const LAST_NAME      = 'last_name';
    public const GENDER         = 'gender';
    public const PROFILE        = 'profile';
    public const USERNAME       = 'username';
    public const EMAIL          = 'email';
    public const PASSWORD       = 'password';
    public const CREATED_BY     = 'created_by';
    public const CREATED_AT     = 'created_at';
    public const UPDATED_AT     = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        User::ID,
        User::FIRST_NAME,
        User::LAST_NAME,
        User::GENDER,
        User::PROFILE,
        User::USERNAME,
        User::EMAIL,
        User::PASSWORD,
        User::CREATED_BY,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fullName(){
        return ($this->gender == 'Male'?'Mr. ':'Ms. ').$this->first_name.' '.$this->last_name;
    }

    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
