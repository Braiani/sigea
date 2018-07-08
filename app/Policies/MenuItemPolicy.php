<?php

namespace App\Policies;

use TCG\Voyager\Contracts\User;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\DataType;
use Illuminate\Auth\Access\HandlesAuthorization;
use TCG\Voyager\Policies\MenuItemPolicy as MenuPolicy;

class MenuItemPolicy extends MenuPolicy
{
    use HandlesAuthorization;

    protected static $datatypes = null;
    protected static $permissions = null;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    protected function checkPermission(User $user, $model, $action)
    {
        if (self::$permissions == null) {
            self::$permissions = Voyager::model('Permission')->all();
        }

        if (self::$datatypes == null) {
            self::$datatypes = DataType::all()->keyBy('slug');
        }

        $regex = str_replace('/', '\/', preg_quote(route('sigea.dashboard')));
        $slug = preg_replace('/'.$regex.'/', '', $model->link(true));
        $slug = str_replace('/', '', $slug);

        if ($str = self::$datatypes->get($slug)) {
            $slug = $str->name;
        }

        if ($slug == '') {
            $slug = 'admin';
        }
        // echo('<script>console.log("1: ' . $slug . '"); </script>');
        // If permission doesn't exist, we can't check it!
        if (!self::$permissions->contains('key', 'browse_'.$slug)) {
            return true;
        }

        if ($slug !== 'admin') {
            return $user->hasPermission('browse_'.$slug);
        }else{
            return true;
        }
    }
}
