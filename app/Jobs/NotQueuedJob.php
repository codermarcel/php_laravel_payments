<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;

abstract class NotQueuedJob
{
    use SerializesModels;

    public function attempts()
    {
    	return 1;
    }
}
