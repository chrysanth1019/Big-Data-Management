<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class UserActivity extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
    ];
    
    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Log a new user activity.
     *
     * @param int $userId
     * @param string $action
     * @param string $description
     * @return \App\Models\UserActivity
     */
    public static function log($userId, $action, $description)
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip(),
        ]);
    }
}