<?php

namespace App\Console\Commands;

use App\Models\Feature;
use App\Services\ArcheageBoat;
use Carbon\Carbon;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Guild\Guild;
use Illuminate\Console\Command;
use Discord\Discord;
use Discord\DiscordCommandClient;
use React\EventLoop\Factory as EventLoopFactory;

class RunBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the bot';

    /**
     * Discord object.
     *
     * @var 
     */
    public $_discord;
    public $_discord_command;

    private $_discord_token = "";
    private $_discord_prefix = "";
    private $_discord_name = "";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->_discord_token = env('DISCORD_BOT_TOKEN');
        $this->_discord_prefix = env('DISCORD_BOT_PREFIX');
        $this->_discord_name = env('DISCORD_BOT_NAME');

        /*$this->_discord = new Discord([
            'token' => $this->_discord_token,
        ]);*/


    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $discord = new DiscordCommandClient([
            'token' => $this->_discord_token,
            'prefix' => $this->_discord_prefix,
            'name' => $this->_discord_name,
        ]);


        $discord->registerCommand('ping', function ($message) {
            return 'pong!';
        }, [
            'description' => 'pong!',
        ]);


        $discord->registerCommand('archeage-boat', function ($message, $params ) {

            if(isset($params[0]) && in_array($params[0], [1,2,3,4])){

                $now = Carbon::now()->toDateTimeString();
                $now_plus_10 = Carbon::now()->addMinutes(10)->toDateTimeString();
                $now_plus_20 = Carbon::now()->addMinutes(20)->toDateTimeString();

                $feature = Feature::where('group', 'archeage')->where('name', 'boat')->first();

                $data = $feature->data;

                $data["position"]   = $params[0];
                $data["time"]       = $now;

                $feature->data = $data;

                $feature->save();

                switch ($params[0]) {
                    case 1:
                        return "Boat arrived at Solis Headlands at {$now}, Departing at {$now_plus_20}.";
                    case 2:
                        return "Boat leaving Solis Headlands at {$now}, Arriving at Two Crowns at {$now_plus_10}.";
                    case 3:
                        return "Boat arrived at Two Crowns at {$now}, Departing at {$now_plus_20}.";
                    case 4:
                        return "Boat leaving Two Crowns at {$now}, Arriving at Solis Headlands at {$now_plus_10}.";
                }

            }else{
                return "None or invalid parameters. Usage !archeage-boat 1-4 i.e. !archeage-boat 3";
            }

        }, [
            'description' => 'set position of the boat in Archeage. Usage !archeage-boat 1-4 i.e. !archeage-boat 3',
        ]);



        $discord->on('ready', function ($discord) {
            echo "Bot is ready.", PHP_EOL;

            #$guild = $discord->factory(Guild::class, ['id' => "606803379297189900"]);

            $channel = $discord->factory(Channel::class, ['id' => "752796865417838632"]);
            $channel->sendMessage("Bot is ready.");


        });

        $discord->getLoop()->addPeriodicTimer(10, function () use ($discord) {

            #$channel = $discord->factory(Channel::class, ['id' => "752796865417838632"]);
            #$channel->sendMessage(Carbon::now()->toDateTimeString());

            $Boat = new ArcheageBoat();
            $Boat($discord);
        });

        $discord->run();


        return 0;
    }
}
