<?php

namespace App\Models\Enums;

class Request extends Enum
{
    const STATUS_CLOSE = 'close';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_OPEN = 'open';
}
