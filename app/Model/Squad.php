<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Squad extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'squads';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['uuid', 'product_uuid', 'name', 'description'];
    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
}
