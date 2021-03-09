<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->hideSensitiveRequestDetails();

        Telescope::night();

        Telescope::tag(function (IncomingEntry $entry) {
            $tags = [];

            if ($entry->type === 'job') {
                $tags[] = 'Host:' . $entry->content['hostname'];
                $tags[] = 'Status:' . $entry->content['status'];
                $tags[] = 'Connection:' . $entry->content['connection'];
                $tags[] = 'Queue:' . $entry->content['queue'];

                $list = (array)explode('\\', str_ireplace('App\Jobs\\', '', $entry->content['name']));
                $list = array_map(function ($v) {
                    return 'Job:' . $v;
                }, $list);
                $tags = array_merge($tags, $list);
            }

            if ($entry->type === 'command') {
                $tags[] = 'Host:' . $entry->content['hostname'];
                $tags[] = 'Command:' . $entry->content['command'];
                $tags[] = 'Code:' . $entry->content['exit_code'];

                $list = (array)explode(':', strtolower($entry->content['command']));
                while($list) {

                    $tags[] = 'Command:'. implode(':', $list);
                    array_pop($list);
                }
            }

            if ($entry->type === 'request') {
                $tags[] = 'Status:' . $entry->content['response_status'];
            }

            if ($entry->type == 'mail') {
                // Cut down email sizes in DB, by stripping body
                if ($this->app->environment('production') || env('TELESCOPE_LIMIT_MAILBODY', false)) {
                    $message = '<a style="display:block;background:#fff;min-height:300px;padding:20px;" href="%s" target="_blank">Go to %s to see full email</a>';
                    $to = array_keys($entry->content['to'] ?? []);

                    switch (config('mail.mailers.smtp.host', '')) {
                        case 'smtp.mailtrap.io':
                            $message = sprintf($message, 'https://mailtrap.io/', 'Mailtrap');
                            $tags[] = 'smtp:mailtrap';
                            break;
                        case 'smtp.postmarkapp.com':
                            $message = sprintf($message, 'https://account.postmarkapp.com/' . array_shift($to) . '', 'Postmarkapp');
                            $tags[] = 'smtp:postmark';
                            break;
                        default:
                            $message = sprintf($message, '#', 'external mail provider');
                            $tags[] = 'smtp:unknown';
                    }

                    $entry->content['html'] = $message;
                    $entry->content['raw'] = '';
                }
            }

            return $tags;
        });


        Telescope::filter(function (IncomingEntry $entry) {
            // Cut down telescope size in DB, by only logging slow queries (as defined in config/telescope.php)
            if ($entry->type == 'query') {
                if ($this->app->environment('production') || env('TELESCOPE_LIMIT_SLOWQUERY', false)) {
                    if (!in_array('slow', $entry->tags)) {
                        return false;
                    }
                }
            }

            if (!$this->app->environment('production')) {
                return true;
            }

            return true ||
                $entry->isReportableException() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails()
    {
        if (!$this->app->environment('production')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }


    /**
     * Set the necessary permission to access the Telescope gate (in non-local environments)
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return $user->hasPermission('telescope', 'admin');
        });
    }
}
