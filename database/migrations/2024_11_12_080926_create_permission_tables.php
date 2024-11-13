<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define table names
        $permissionsTable = 'permissions';
        $rolesTable = 'roles';
        $modelHasPermissionsTable = 'model_has_permissions';
        $modelHasRolesTable = 'model_has_roles';
        $roleHasPermissionsTable = 'role_has_permissions';

        // Create permissions table
        Schema::create($permissionsTable, function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        // Create roles table
        Schema::create($rolesTable, function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('guard_name', 125);
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        // Create model_has_permissions table
        Schema::create($modelHasPermissionsTable, function (Blueprint $table) use ($permissionsTable) {
            $table->foreignId('permission_id')
                ->constrained($permissionsTable)
                ->cascadeOnDelete();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');
            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_model_type_primary');
        });

        // Create model_has_roles table
        Schema::create($modelHasRolesTable, function (Blueprint $table) use ($rolesTable) {
            $table->foreignId('role_id')
                ->constrained($rolesTable)
                ->cascadeOnDelete();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');
            $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_role_model_type_primary');
        });

        // Create role_has_permissions table
        Schema::create($roleHasPermissionsTable, function (Blueprint $table) use ($permissionsTable, $rolesTable) {
            $table->foreignId('permission_id')
                ->constrained($permissionsTable)
                ->cascadeOnDelete();
            $table->foreignId('role_id')
                ->constrained($rolesTable)
                ->cascadeOnDelete();
            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        // Clear the cache if necessary
        Cache::forget('permission.cache.key');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};
