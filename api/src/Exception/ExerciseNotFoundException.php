<?php

namespace App\Exception;

class ExerciseNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('Exercise not found.');
    }
}
