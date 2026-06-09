<?php

namespace App\Exception;

class WorkoutSessionNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('Workout session not found.');
    }
}
