<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dealer_applications', function (Blueprint $table) {
            if (! Schema::hasColumn('dealer_applications', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (! Schema::hasColumn('dealer_applications', 'tax_department')) {
                $table->string('tax_department')->nullable()->after('website');
            }
            if (! Schema::hasColumn('dealer_applications', 'tax_no')) {
                $table->string('tax_no')->nullable()->after('tax_department');
            }
            if (! Schema::hasColumn('dealer_applications', 'field_of_activity')) {
                $table->string('field_of_activity')->nullable()->after('tax_no');
            }
            if (! Schema::hasColumn('dealer_applications', 'company_references')) {
                $table->string('company_references')->nullable()->after('field_of_activity');
            }
            if (! Schema::hasColumn('dealer_applications', 'dealer_type')) {
                $table->string('dealer_type', 32)->nullable()->after('company_references');
            }
            if (! Schema::hasColumn('dealer_applications', 'message')) {
                $table->text('message')->nullable()->after('dealer_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dealer_applications', function (Blueprint $table) {
            $cols = ['website', 'tax_department', 'tax_no', 'field_of_activity', 'company_references', 'dealer_type', 'message'];
            $drop = array_values(array_filter($cols, fn ($c) => Schema::hasColumn('dealer_applications', $c)));
            if ($drop) {
                $table->dropColumn($drop);
            }
        });
    }
};
