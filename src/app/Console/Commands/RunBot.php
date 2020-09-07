<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Discord\Discord;
use Discord\DiscordCommandClient;

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /*$this->_discord = new Discord([
            'token' => env('DISCORD_BOT_TOKEN'),
        ]);*/

        echo env('DISCORD_BOT_TOKEN');

        $this->_discord_command = new DiscordCommandClient([
            'token' => env('DISCORD_BOT_TOKEN'),
            'prefix' => env('DISCORD_BOT_PREFIX'),
            'name' => env('DISCORD_BOT_NAME'),
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        /*$this->_discord->on('ready', function ($discord) {
            echo "Bot is ready!", PHP_EOL;

            $game = $discord->factory(Game::class, [
                'name' => "I'm A Stupid Bot",
            ]);

            $discord->updatePresence($game);
        
            // Listen for messages.
            $discord->on('message', function ($message, $discord) {
                echo "{$message->author->username}: {$message->content}",PHP_EOL;
            });

        });*/


        $this->_discord_command->registerCommand('ping', function ($message) {
            return 'pong!';
        }, [
            'description' => 'pong!',
        ]);

        $this->_discord_command->run();

        #$this->_discord->run();

        return 0;
    }
}
