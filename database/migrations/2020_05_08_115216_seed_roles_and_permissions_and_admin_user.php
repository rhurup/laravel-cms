<?php

use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SeedRolesAndPermissionsAndAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $AdminRole = \App\Models\Acl\AclRole::create(['name' => 'admin', 'display_name' => 'Administrator']);
        $UserRole = \App\Models\Acl\AclRole::create(['name' => 'user', 'display_name' => 'Normal user']);

        $AdminPermissions = [];
        $AdminPermissions[] = ['group' => 'admin','key' => 'login','description' => 'Login in at the administration'];
        // Users
        $AdminPermissions[] = ['group' => 'users','key' => 'create','description' => 'Create user from administration'];
        $AdminPermissions[] = ['group' => 'users','key' => 'browse','description' => 'Browse users from administration'];
        $AdminPermissions[] = ['group' => 'users','key' => 'update','description' => 'Edit users from administration'];
        $AdminPermissions[] = ['group' => 'users','key' => 'delete','description' => 'Delete users from administration'];
        // Roles
        $AdminPermissions[] = ['group' => 'roles','key' => 'create','description' => 'Create roles from administration'];
        $AdminPermissions[] = ['group' => 'roles','key' => 'update','description' => 'Edit roles from administration'];
        $AdminPermissions[] = ['group' => 'roles','key' => 'browse','description' => 'Browse roles from administration'];
        $AdminPermissions[] = ['group' => 'roles','key' => 'delete','description' => 'Delete roles from administration'];
        // Permissions
        $AdminPermissions[] = ['group' => 'permissions','key' => 'create','description' => 'Create permissions from administration'];
        $AdminPermissions[] = ['group' => 'permissions','key' => 'update','description' => 'Edit permissions from administration'];
        $AdminPermissions[] = ['group' => 'permissions','key' => 'browse','description' => 'Browse permissions from administration'];
        $AdminPermissions[] = ['group' => 'permissions','key' => 'delete','description' => 'Delete permissions from administration'];
        // Settings
        $AdminPermissions[] = ['group' => 'settings','key' => 'create','description' => 'Create settings from administration'];
        $AdminPermissions[] = ['group' => 'settings','key' => 'update','description' => 'Edit settings from administration'];
        $AdminPermissions[] = ['group' => 'settings','key' => 'browse','description' => 'Browse settings from administration'];
        $AdminPermissions[] = ['group' => 'settings','key' => 'delete','description' => 'Delete settings from administration'];
        // Timezones table
        $AdminPermissions[] = ['group' => 'timezones','key' => 'create','description' => 'Create timezone from administration'];
        $AdminPermissions[] = ['group' => 'timezones','key' => 'update','description' => 'Edit timezone from administration'];
        $AdminPermissions[] = ['group' => 'timezones','key' => 'browse','description' => 'Browse timezone from administration'];
        $AdminPermissions[] = ['group' => 'timezones','key' => 'delete','description' => 'Delete timezone from administration'];
        // Countries table
        $AdminPermissions[] = ['group' => 'countries','key' => 'create','description' => 'Create country from administration'];
        $AdminPermissions[] = ['group' => 'countries','key' => 'update','description' => 'Edit country from administration'];
        $AdminPermissions[] = ['group' => 'countries','key' => 'browse','description' => 'Browse country from administration'];
        $AdminPermissions[] = ['group' => 'countries','key' => 'delete','description' => 'Delete country from administration'];
        // Languages table
        $AdminPermissions[] = ['group' => 'languages','key' => 'create','description' => 'Create languages from administration'];
        $AdminPermissions[] = ['group' => 'languages','key' => 'update','description' => 'Edit languages from administration'];
        $AdminPermissions[] = ['group' => 'languages','key' => 'browse','description' => 'Browse languages from administration'];
        $AdminPermissions[] = ['group' => 'languages','key' => 'delete','description' => 'Delete languages from administration'];

        $UserPermissions = [];
        $UserPermissions[] = ['group' => 'user', 'key' => 'login', 'description' => 'Login in at the frontend'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'register', 'description' => 'Register in at the frontend'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'logout', 'description' => 'Logout in at the frontend'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'verify-email', 'description' => 'Verify email in at the frontend'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'send-reset-password-link', 'description' => 'Send reset password email in at the frontend'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'confirm-reset-password-link', 'description' => 'Confirm reset password email in at the frontend'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'show', 'description' => 'View own user'];
        $UserPermissions[] = ['group' => 'user', 'key' => 'update', 'description' => 'Edit own user'];

        foreach($AdminPermissions as $AdminPermission){
            $permission = \App\Models\Acl\AclPermission::create($AdminPermission);
            $AdminRole->addPermission($permission->id);
        }

        foreach($UserPermissions as $UserPermission){
            $permission = \App\Models\Acl\AclPermission::create($UserPermission);
            $UserRole->addPermission($permission->id);
            $AdminRole->addPermission($permission->id);
        }

        echo "Creating public user\n";
        $User                    = new User();
        $User->name              = 'Public user (Dont delete)';
        $User->email             = 'public@example.com';
        $User->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $User->password          = bcrypt(Str::random(16) . Carbon::now()->format('Y-m-d'));
        $User->api_token         = Str::random(64);
        $User->remember_token    = Str::random(64);
        $User->avatar            = 'images/avatar_default.png';
        $User->timezone_id          = (\App\Models\Countries\CountriesZones::where("zone_name", 'Europe/London')->first())->id;
        $User->language_id          = (\App\Models\Countries\CountriesLanguages::where("lang", 'en-GB')->first())->id;
        $User->save();
        \App\Models\Users\UserRoles::create(['role_id'=> $UserRole->id, 'user_id' => $User->id]);

        echo "Creating admin user\n";
        echo "Username: admin@example.com\n";
        echo "Password: YouShouldChangeThis" . Carbon::now()->format('Y-m-d') . "\n";

        $User                    = new User();
        $User->name              = 'admin';
        $User->email             = 'admin@example.com';
        $User->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $User->password          = bcrypt('YouShouldChangeThis' . Carbon::now()->format('Y-m-d'));
        $User->api_token         = Str::random(64);
        $User->remember_token    = Str::random(64);
        $User->avatar            = 'images/avatar_default.png';
        $User->timezone_id          = (\App\Models\Countries\CountriesZones::where("zone_name", 'Europe/London')->first())->id;
        $User->language_id          = (\App\Models\Countries\CountriesLanguages::where("lang", 'en-GB')->first())->id;

        $User->save();
        \App\Models\Users\UserRoles::create(['role_id'=> $AdminRole->id, 'user_id' => $User->id]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
