<?php

namespace Database\Seeders;

use App\Models\AdminLogin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $arr = [
            'dashboard',
            'admin-user' => [
                'add-admin-user',
                'edit-admin-user',
                'delete-admin-user',
                'restore-admin-user',
            ],
            'ask-expert' => [
                'update-ask-expert',
            ],
            'expert' => [
                'add-expert',
                'edit-expert',
                'delete-expert',
                'restore-expert',
                'update-expert-status',
                'update-expert-discussion-status',
            ],
            'partner' => [
                'add-partner',
                'edit-partner',
                'delete-partner',
                'restore-partner',
                'update-partner-status',
            ],
            'podcast' => [
                'add-podcast',
                'edit-podcast',
                'delete-podcast',
                'restore-podcast',
                'update-podcast-status',
            ],
            'page' => [
                'edit-page'
            ],
            'country' => [
                'add-country',
                'edit-country',
            ],
            'cityState' => [
                'edit-cityState',
            ],
            'config' => [
                'add-config',
                'edit-config',
            ],
            'speciality' => [
                'add-speciality',
                'edit-speciality',
                'update-speciality-status',
            ],
            'community' => [
                'add-community',
                'edit-community',
                'delete-community',
                'restore-community',
                'update-community-status',
            ],
            'role' => [
                'add-role',
                'edit-role',
                'delete-role',
            ],
            'article' => [
                'add-article',
                'edit-article',
                'delete-article',
                'restore-article',
                'update-article-status',
            ],
            'case' => [
                'add-case',
                'edit-case',
                'update-case-status',
                'restore-case',
                'delete-case',
                'delete-case-question-mcq',
                'case-question-mcq',
                'case-question-comment',
                'update-case-comment-status',
            ],
            'slider' => [
                'add-slider',
                'edit-slider',
                'restore-slider',
                'delete-slider',
                'update-slider-status',
            ],
            'notification' => [
                'email-notification',
                'add-email-notification',
                'edit-email-notification',
                'delete-email-notification',
                'restore-email-notification',
                'update-email-notification-status',
            ],
            'master-notification' => [
                'add-master-notification',
                'edit-master-notification',
                'delete-master-notification',
                'restore-master-notification',
                'update-master-notification-status',
            ],
            'sms-notification' => [
                'add-sms-notification',
                'edit-sms-notification',
                'delete-sms-notification',
                'restore-sms-notification',
                'update-sms-notification-status',
            ],
            'push-notification' => [
                'add-push-notification',
                'edit-push-notification',
                'delete-push-notification',
                'restore-push-notification',
                'update-push-notification-status',
            ],
            'page-notification' => [
                'add-page-notification',
                'edit-page-notification',
                'update-page-notification-status',
                'delete-page-notification',
                'restore-page-notification',
            ],
            'series' => [
                'add-series',
                'edit-series',
                'delete-series',
                'restore-series',
                'update-series-status',
            ],
            'dataFilters' => [
                'add-dataFilters',
                'edit-dataFilters',
                'delete-dataFilters',
                'restore-dataFilters',
            ],
            'communication' => [
                'add-communication',
                'edit-communication',
                'delete-communication',
                'view-report'
            ],
            // 'app-notification',
            // 'add-app-notification',
            // 'delete-app-notification',
            'forum' => [
                'add-forum',
                'update-forum-status',
                'edit-forum',
                'restore-forum',
                'delete-forum',
            ],
            'video' => [
                'add-video',
                'edit-video',
                'update-video-status',
                'delete-video',
                'restore-video',
            ],
            'certificate' => [
                'add-certificate',
                'edit-certificate',
                'delete-certificate',
                'restore-certificate',
            ],
            'newsletter' => [
                'add-newsletter',
                'edit-newsletter',
                'delete-newsletter',
                'update-newsletter-status',
            ],
            'cme' => [
                'add-cme',
                'edit-cme',
                'delete-cme',
                'update-cme-status',
            ],
            'question-bank' => [
                'add-question-bank',
                'edit-question-bank',
                'delete-question-bank',
            ],
            'universal-member-upload' => [
                'add-universal-member-upload',
                'download-universal-member-upload-log'
            ],
            'protected-content' => [
                'add-protected-content'
            ],
            'live-event' => [
                'add-live-event',
                'update-live-event'
            ],
            'immediate-action' => [
                'add-immediate-action',
                'edit-immediate-action',
                'delete-immediate-action'
            ],
            'promotion' => [
                'add-promotion',
                'edit-promotion',
                'delete-promotion',
                'update-promotion-status',
                'restore-promotion'
            ],
            'webview' => [
                'add-webview',
                'edit-webview',
                'delete-webview',
                'update-webview-status',
                'restore-webview'
            ],
            'mci-verification'
        ];

        $dummy_user = [
            [
                'username' => 'testsuperadmin',
                'password' => Hash::make('admin'),
                'email'    => 'testsuperadmin@gmail.com',
                'type'     => 'superadmin',
                'ip_address' => '127.0.0.1',
            ],
            [
                'username' => 'testadmin',
                'password' => Hash::make('admin'),
                'email'    => 'testadmin@gmail.com',
                'type'     => 'admin',
                'ip_address' => '127.0.0.1',
            ]
        ];

        $role = Role::updateOrCreate(['name' => 'superadmin', 'guard_name' => 'api']);
        $role1 = Role::updateOrCreate(['name' => 'admin', 'guard_name' => 'api']);

        foreach ($arr as $key => $a) {
            if (is_array($a)) {
                $permission = Permission::updateOrCreate([
                    'name' => $key,
                    'guard_name' => 'api'
                ]);

                $role->givePermissionTo($permission);
                $role1->givePermissionTo($permission);

                foreach ($a as $val) {
                    $parent = Permission::updateOrCreate([
                        'name' => $val,
                        'is_parent' => $permission->id,
                        'guard_name' => 'api'
                    ]);

                    $role->givePermissionTo($parent);
                    $role1->givePermissionTo($parent);
                }
            } else {
                $permission = Permission::updateOrCreate([
                    'name' => $a,
                    'guard_name' => 'api'
                ]);

                $role->givePermissionTo($permission);
                $role1->givePermissionTo($permission);
            }
        }

        foreach ($dummy_user as $value) {
            $getUser = AdminLogin::where('username', $value['username'])->first();
            if (empty($getUser)) {
                $user = AdminLogin::create($value);
                if ($user->username == 'testsuperadmin') {
                    $user->assignRole($role->id);
                }
                if ($user->username == 'testadmin') {
                    $user->assignRole($role1->id);
                }
            }
        }
    }
}
