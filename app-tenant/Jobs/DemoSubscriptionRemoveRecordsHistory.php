<?php

namespace AppTenant\Jobs;

use AppTenant\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DemoSubscriptionRemoveRecordsHistory implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tenants = Tenant::all();
        $date_delete_before = now()->subMonths(3);
        
        if ($tenants->isNotEmpty()) {
            $tenants->each(function($tenant) use($date_delete_before) {
                $tenant->run(function() use($date_delete_before) {
                    DB::update("UPDATE activity SET deleted_at = ? WHERE created_at <= ? AND deleted_at IS NULL", [now(), $date_delete_before]);
                    DB::update("UPDATE notifications SET deleted_at = ? WHERE created_at <= ? AND deleted_at IS NULL", [now(), $date_delete_before]);
                    DB::update("UPDATE comments SET deleted_at = ? WHERE created_at <= ? AND deleted_at IS NULL", [now(), $date_delete_before]);
                });
            });
        }
    }
}
