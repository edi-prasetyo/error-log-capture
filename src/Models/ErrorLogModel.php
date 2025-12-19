<?php

namespace EdiPrasetyo\ErrorLogCapture\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLogModel extends Model
{
    protected $table = 'error_logs';

    protected $fillable = [
        'exception',
        'message',
        'file',
        'line',
        'trace',
        'url',
        'method',
        'ip',
        'user_id',
        'hash',
        'count',
        'solved',
        'occurred_at',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    /**
     * Optional relation to user model
     * Works if app has users table
     */
    public function user()
    {
        return $this->belongsTo(
            config('auth.providers.users.model', \App\Models\User::class),
            'user_id'
        );
    }
}
