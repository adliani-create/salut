<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'password',
        'role_id',
        'photo',
        'nim',
        'status',
        'faculty',
        'major',
        'semester',
        'ipk',
        'password_myut',
        'angkatan',
        'referral_code',
        'referred_by',
        'is_affiliator',
        'bank_account',
        'ktpu_file',
        'ktpu_status',
        'ktm_file',
        'has_seen_admission_receipt',
    ];

    /**
     * Get the user's role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function completedMaterials()
    {
        return $this->belongsToMany(LmsMaterial::class, 'lms_material_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }

    /**
     * Check if user is mahasiswa
     */
    public function isMahasiswa(): bool
    {
        return $this->role && $this->role->name === 'mahasiswa';
    }

    /**
     * Check if user is affiliator
     */
    public function isAffiliator(): bool
    {
        return $this->role && $this->role->name === 'affiliator';
    }

    /**
     * Check if user is mitra
     */
    public function isMitra(): bool
    {
        return $this->role && $this->role->name === 'mitra';
    }

    /**
     * Get the student registration record.
     */
    public function registration()
    {
        return $this->hasOne(Registration::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'target_id')->where('target_model', 'User');
    }

    public function academicRecords()
    {
        return $this->hasMany(AcademicRecord::class);
    }

    /**
     * Affiliate / Mitra relationships
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function mitraProfile()
    {
        return $this->hasOne(MitraProfile::class);
    }

    public function pointLedgers()
    {
        return $this->hasMany(PointLedger::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function getTotalPointsAttribute()
    {
        $credits = $this->pointLedgers()->where('type', 'credit')->sum('amount');
        $debits = $this->pointLedgers()->where('type', 'debit')->sum('amount');
        return $credits - $debits;
    }


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
        'password' => 'hashed',
    ];
}
