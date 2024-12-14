<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE TRIGGER decrement_buku_stok_after_confirm
        AFTER UPDATE ON peminjaman
        FOR EACH ROW
        BEGIN
            -- Check if the status is updated to 1 (confirmed)
            IF NEW.status = 1 AND OLD.status != 1 THEN
                -- Decrement the stock of the related book using the detail_peminjaman table
                UPDATE buku
                JOIN detail_peminjaman ON detail_peminjaman.peminjaman_id = NEW.id
                SET buku.stok = buku.stok - 1
                WHERE buku.id = detail_peminjaman.buku_id;
            END IF;
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decrement_buku_stok_trigger');
    }
};
