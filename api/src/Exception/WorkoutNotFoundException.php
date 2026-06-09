<?php

namespace App\Exception;

class WorkoutNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('Workout not found.');
    }
}
