<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtbAnalyzedDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtb_analyzed_datas', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->string('equipment_type');
            $table->string('item_category');
            $table->string('item_sub_category');
            $table->string('demand_qty')->nullable();
            $table->string('demand_unit')->nullable();
            $table->string('demand_unit_price')->nullable();
            $table->string('demand_total_price')->nullable();
            $table->string('analyzed_data_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtb_analyzed_datas');
    }
}
