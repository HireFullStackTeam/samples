<?php
namespace App\Contracts\Feesy\Components;

use App\Models\Componentables\Componentable;



interface Delete
{

    /**
     * @param Componentable $componentable
     * @return bool
     */
    public static function delete(Componentable $componentable);
}
