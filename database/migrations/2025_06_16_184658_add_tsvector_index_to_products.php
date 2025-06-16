<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("CREATE INDEX idx_products_title_tsv ON products USING GIN (to_tsvector('simple', title))");
    }

    public function down()
    {
        DB::statement("DROP INDEX IF EXISTS idx_products_title_tsv");
    }
};
