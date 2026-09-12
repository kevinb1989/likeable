<?php

declare(strict_types=1);

namespace Kevinb1989\Likeable;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ModelNotYetLikedException extends Exception
{
    public function __construct(Model $model)
    {
        parent::__construct("Model #{$model->getKey()} has not been liked by the authenticated user.", 0);
    }
}
