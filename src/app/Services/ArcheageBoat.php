<?php

namespace App\Services;
use App\Models\Feature;
use Carbon\Carbon;
use Discord\Discord;
use Discord\Parts\Channel\Channel;

/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 08/09/20
 * Time: 09:22
 */

class ArcheageBoat
{

    public function __invoke($discord){

        $feature = Feature::where('group', 'archeage')->where('name', 'boat')->first();

        $data = $feature->data;

        var_dump($data);

        $now = Carbon::now();
        $start = Carbon::parse($data["time"]);
        $now_plus_10 = Carbon::parse($data["time"])->addMinutes(10);
        $now_plus_20 = Carbon::parse($data["time"])->addMinutes(20);

        switch ($data["position"]) {
            case 1:
                $end = $start->addMinutes(20);
                break;
            case 2:
                $end = $start->addMinutes(10);
                break;
            case 3:
                $end = $start->addMinutes(20);
                break;
            case 4:
                $end = $start->addMinutes(10);
                break;
        }

        if($now->gt($end)){

            switch ($data["position"]) {
                case 1:
                    $text = "Boat leaving Solis Headlands at {$start}, Arriving at Two Crowns at {$now_plus_10}.";
                    $data["position"] = 2;
                    $data["time"] = $now_plus_10->toDateTimeString();
                    break;
                case 2:
                    $text = "Boat arrived at Two Crowns at {$start}, Departing at {$now_plus_20}.";
                    $data["position"] = 3;
                    $data["time"] = $now_plus_20->toDateTimeString();
                    break;
                case 3:
                    $text = "Boat leaving Two Crowns at {$start}, Arriving at Solis Headlands at {$now_plus_10}.";
                    $data["position"] = 4;
                    $data["time"] = $now_plus_10->toDateTimeString();
                    break;
                case 4:
                    $text = "Boat arrived at Solis Headlands at {$start}, Departing at {$now_plus_20}.";
                    $data["position"] = 1;
                    $data["time"] = $now_plus_20->toDateTimeString();
                    break;
            }

            $feature->data = $data;
            $feature->save();

            #announce to discord
            $channel = $discord->factory(Channel::class, ['id' => "752796865417838632"]);
            $channel->sendMessage($text);
        }

        return 0;

    }
}