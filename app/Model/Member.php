<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Member extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'members';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['uuid', 'name', 'role', 'squad_uuid'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
}
