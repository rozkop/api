<?php

namespace App\Models\CrossUsage;

trait HasUserReacted
{
    public function isUserReacting()
    {
        if(auth('sanctum')->user())
        {
            return$this->reacted();
        }
        else return ['error' => 'No login user'];

    }
}
