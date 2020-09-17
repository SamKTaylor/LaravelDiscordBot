<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArcheageBoatFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $data = [
            "channel"   => "archeage-boat",
            "position"  => 1,
            "time"      => Carbon::now()->toDateTimeString(),
        ];

        $feature = new \App\Models\Feature;
        $feature->name      = "boat";
        $feature->group     = "archeage";
        $feature->data      = $data;
        $feature->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
