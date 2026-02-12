<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 06/02/2018
 * Time: 04:39 PM
 */

namespace App\Models\Traits;


use Jenssegers\Date\Date;

trait DatesTranslator
{
    public function getCreatedAtAttribute($created_at)
    {
        return new Date($created_at);
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        return new Date($updated_at);
    }

    public function getDeleteAtAttribute($deleted_at)
    {
        return new Date($deleted_at);
    }

    public function getCompletedAtAttribute($completed_at)
    {
        return new Date($completed_at);
    }
}