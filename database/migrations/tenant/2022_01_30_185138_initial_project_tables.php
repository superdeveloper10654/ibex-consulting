<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialProjectTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function(Blueprint $table) {
            $table->id();
            $table->integer('profile_id');
            $table->text('text');
            $table->text('img');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('all_tasks', function(Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->integer('column_id');
            $table->integer('order_id');
            $table->integer('progress');
            $table->timestamps();
        });

        Schema::create('applications', function(Blueprint $table) {
            $table->id();
            $table->integer('task_order_id');
            $table->integer('works_id');
            $table->integer('measure_id');
            $table->string('title');
            $table->text('description');
            $table->json('items');
            $table->float('net');
            $table->timestamp('period_from')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('period_to')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('status')->comment('Model ApplicationStatus');
            $table->timestamps();
        });

        Schema::create('assessments', function(Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('profile_id');
            $table->string('title');
            $table->json('measured_items');
            $table->json('deducted_items');
            $table->text('description');
            $table->float('net');
            $table->timestamp('period_from')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('works_id');
            $table->integer('status')->comment('Model AssessmentStatus');
            $table->timestamps();
        });

        Schema::create('contracts', function(Blueprint $table) {
            $table->id();
            $table->string('contractor_name');
            $table->string('order_ref');
            $table->string('contract_name');
            $table->text('kml_filepath');
            $table->timestamps();
        });

        Schema::create('early_warnings', function(Blueprint $table) {
            $table->id();
            $table->integer('task_order_id');
            $table->integer('profile_id');
            $table->integer('works_id');
            $table->string('title');
            $table->text('description');
            $table->integer('effect1');
            $table->integer('effect2');
            $table->integer('effect3');
            $table->integer('effect4');
            $table->integer('status')->comment('Model EarlyWarningStatus');
            $table->timestamp('date_notified')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });

        Schema::create('early_warning_comments', function(Blueprint $table) {
            $table->id();
            $table->integer('profile_id');
            $table->string('early_warning_id');
            $table->text('msg');
            $table->timestamps();
        });

        Schema::create('instructions', function(Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('profile_id');
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->decimal('latitude', 20, 16);
            $table->decimal('longitude', 20, 16);
            $table->timestamp('start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('finish')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('duration');
            $table->string('pattern');
            $table->integer('works_id');
            $table->integer('status')->comment('Model InstructionStatus');
            $table->timestamps();
        });

        Schema::create('instruction_comments', function(Blueprint $table) {
            $table->id();
            $table->integer('profile_id');
            $table->integer('instruction_id');
            $table->text('msg');
            $table->timestamps();
        });

        Schema::create('invoices', function(Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('profile_id');
            $table->string('title');
            $table->text('description');
            $table->float('net');
            $table->timestamp('start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('finish')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('works_id');
            $table->integer('status')->comment('Model InvoiceStatus');
            $table->timestamps();
        });

        Schema::create('measures', function(Blueprint $table) {
            $table->id();
            $table->integer('task_order_id');
            $table->integer('profile_id');
            $table->string('site_name');
            $table->json('quantified_items');
            $table->json('linear_items');
            $table->text('description');
            $table->integer('works_id');
            $table->integer('status')->comment('Model MeasureStatus');
            $table->timestamps();
        });

        Schema::create('MMB_tasks', function(Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->integer('column_id');
            $table->integer('order_id');
            $table->integer('progress');
            $table->timestamps();
        });

        Schema::create('notifications', function(Blueprint $table) {
            $table->id();
            $table->integer('profile_id');
            $table->text('text');
            $table->text('img');
            $table->timestamps();
        });

        Schema::create('payments', function(Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('works_id');
            $table->float('cuml_net');
            $table->text('description');
            $table->json('items');
            $table->timestamp('from_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('due_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('status')->comment('Model PaymentStatus');
            $table->timestamps();
        });

        Schema::rename('users', 'profiles');
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->after('id');
            $table->string('last_name')
                ->nullable()
                ->after('first_name');
            $table->string('department')
                ->nullable()
                ->after('password');
            $table->string('organisation')
                ->nullable()
                ->after('department');
            $table->string('phone')
                ->nullable()
                ->after('organisation');
        });

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('profile_id');
            $table->string('title');
            $table->text('narrative');
            $table->string('location');
            $table->decimal('latitude', 20, 16);
            $table->decimal('longitude', 20, 16);
            $table->timestamp('start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('finish')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('duration');
            $table->string('pattern');
            $table->string('contractor');
            $table->integer('status')->comment('Model QuoteStatus');
            $table->timestamps();
        });

        Schema::create('quote_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('quote_id');
            $table->integer('profile_id');
            $table->text('msg');
            $table->timestamps();
        });

        Schema::create('rate_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('works_id');
            $table->string('ref');
            $table->text('item_desc');
            $table->integer('unit')->comment('Model RateCardUnit');
            $table->float('rate');
            $table->string('pin');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->string('profile_id');
            $table->string('title');
            $table->json('measured_items');
            $table->json('deducted_items');
            $table->text('description');
            $table->float('net');
            $table->timestamp('period_from')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('period_to')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('works_id');
            $table->integer('status')->comment('Model TaskStatus');
            $table->timestamps();
        });

        Schema::create('task_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id');
            $table->integer('profile_id');
            $table->integer('works_id');
            $table->string('title');
            $table->text('description');
            $table->text('affected_property');
            $table->string('kml_filepath');
            $table->decimal('latitude', 20, 16);
            $table->decimal('longitude', 20, 16);
            $table->string('PO_no');
            $table->float('baseline_price');
            $table->float('revised_price');
            $table->timestamp('baseline_start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('baseline_completion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('revised_start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('revised_completion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('path');
            $table->string('extension');
            $table->integer('profile_id');
            $table->integer('instruction_id');
            $table->integer('early_warning_id');
            $table->integer('application_id');
            $table->integer('assessment_id');
            $table->timestamps();
        });

        Schema::create('works', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('works')->insertGetId([
            'name'          => 'Civils',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        DB::table('works')->insertGetId([
            'name'          => 'Cabling',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        DB::table('works')->insertGetId([
            'name'          => 'Civils & Cabling',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity');
        Schema::dropIfExists('all_tasks');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('assessments');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('early_warnings');
        Schema::dropIfExists('early_warning_comments');
        Schema::dropIfExists('instructions');
        Schema::dropIfExists('instruction_comments');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('measures');
        Schema::dropIfExists('MMB_tasks');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('quotes');
        Schema::dropIfExists('quote_comments');
        Schema::dropIfExists('rate_cards');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_orders');
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('works');
        
        Schema::rename('profiles', 'users');
        Schema::table('users', function(Blueprint $table) {
            $table->string('name');
            $table->dropColumn(['first_name', 'last_name', 'department', 'organisation', 'phone']);
        });
    }
}
