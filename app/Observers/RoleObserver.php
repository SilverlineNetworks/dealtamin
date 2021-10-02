<?php

namespace App\Observers;

use App\Helper\SearchLog;
use App\Role;
use App\User;

class RoleObserver
{
    public function saving(Role $role)
    {
        if (company()) {
            $role->company_id = company()->id;
        }
    }
}
