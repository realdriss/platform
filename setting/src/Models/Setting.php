<?php

namespace RealDriss\Setting\Models;

use RealDriss\Base\Models\BaseModel;

class Setting extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
