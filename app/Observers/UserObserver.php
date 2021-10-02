<?php

namespace App\Observers;

use App\Helper\SearchLog;
use App\Notifications\NewCompany;
use App\Role;
use App\User;
use Illuminate\Support\Facades\File;

class UserObserver
{
    public function creating(User $user)
    {
        if (company()) {
            $user->company_id = company()->id;
        }
    }

    public function created(User $user)
    {
        // Send verification email to first admin of company
        if(!is_null($user->company_id))
        {
            $user = User::where('company_id', $user->company_id)->firstOrFail();
            if(!is_null($user) && $user->company->verified=='no') {
                $user->notify(new NewCompany($user));
            }
        }

    }

    public function updating(User $user)
    {
        if ($user->roles->count() > 0 && !$user->is_admin) {
            $type = 'Employee';
            $route = 'admin.employee.edit';

            if ($user->is_customer) {
                $type = 'Customer';
                $route = 'admin.customers.show';
            }

            if ($user->isDirty('name')) {
                $original = $user->getRawOriginal('name');
                SearchLog::updateSearchEntry($user->id, $type, $user->name, $route, ['name' => $original]);
            }

            if ($user->isDirty('email')) {
                $original = $user->getRawOriginal('email');
                SearchLog::updateSearchEntry($user->id, $type, $user->email, $route, ['email' => $original]);
            }
        }
    }

    public function deleted(User $user)
    {

        if(!is_null($user->getRawOriginal('image')))
        {
            $path = public_path('user-uploads/avatar/'.$user->getRawOriginal('image'));
            if($path){
                File::delete($path);
            }
        }


        if ($user->roles->count() > 0 && !$user->is_admin) {
            $route = 'admin.employee.edit';

            if ($user->is_customer) {
                $route = 'admin.customers.show';
            }

            SearchLog::deleteSearchEntry($user->id, $route);
        }
    }
}
