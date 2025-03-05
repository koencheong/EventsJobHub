<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'user_id');
    }
    
    public function isPartTimer()
    {
        return $this->role === 'part_timer';
    }

    public function profile()
    {
        return $this->hasOne(PartTimerProfile::class);
    }

    public function partTimerProfile()
    {
        return $this->hasOne(PartTimerProfile::class, 'user_id');
    }
    
      // Messages sent by the user
      public function sentMessages()
      {
          return $this->hasMany(ChMessage::class, 'from_id');
      }
  
      // Messages received by the user
      public function receivedMessages()
      {
          return $this->hasMany(ChMessage::class, 'to_id');
      }

}
