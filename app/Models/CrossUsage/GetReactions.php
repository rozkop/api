<?php

namespace App\Models\CrossUsage;

trait GetReactions
{
    public function getReactions()
    {
        return $this->update([$this->rating = $this->reaction_summary()]);

    }
}
