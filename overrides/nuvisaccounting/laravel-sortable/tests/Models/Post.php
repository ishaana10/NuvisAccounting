<?php

namespace NuvisAccounting\Sortable\Tests\Models;

use NuvisAccounting\Sortable\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Sortable;
}
