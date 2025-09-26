<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('headline')->nullable()->after('username');
            $table->text('bio')->nullable()->after('headline');
            $table->string('location')->nullable()->after('bio');
            $table->string('company')->nullable()->after('location');
            $table->string('website_url')->nullable()->after('company');
            $table->string('avatar_path')->nullable()->after('website_url');
            $table->string('banner_path')->nullable()->after('avatar_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'headline',
                'bio',
                'location',
                'company',
                'website_url',
                'avatar_path',
                'banner_path'
            ]);
        });
    }
};