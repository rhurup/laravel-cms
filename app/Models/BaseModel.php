<?php

namespace App\Models;

use App\Traits\ModelActionsBy;
use App\Traits\ModelHelpers;
use App\Traits\scopeFindById;
use App\Traits\scopeFindByValue;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ModelHelpers, ModelActionsBy;
}
