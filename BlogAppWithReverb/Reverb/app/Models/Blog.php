<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Blog extends Model
{
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

}
