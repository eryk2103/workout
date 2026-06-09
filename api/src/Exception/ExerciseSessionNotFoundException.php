<?php

namespace App\Exception;

class ExerciseSessionNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('Exercise session not found.');
    }
}
