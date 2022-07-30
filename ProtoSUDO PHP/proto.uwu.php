<?php
include __DIR__.'/vendor/autoload.php';
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
//require_once('./logger.php');
$log = "1";
require('./key.php');
$key = getKey();
$discord = new Discord(['token' => $key]);
$discord->on('ready', function (Discord $discord) {
    $log = 1;
    echo "Bot is ready! echo LOG status: {$log};", PHP_EOL;
    $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord, $log) {
        //---------------------------------------- DATA LOGGER ------------------------------------------- //
        echo "LOG status: {$log}";
        $user = "<@{$message->author->id}>";
        $guild = $message->guild->name;
        $content = $message->content;
        if($content === 'p!test'){
            try{
                    $message->reply("Hey! {$user}, estoy vivo!");
                    echo "$user";
                    echo "LOG status: {$log}";
                //var_dump($message);
                } catch (\Throwable $th) {
                    $message->reply("hubo un error: {$th}");
                    echo "$th";
                    echo "LOG status: {$log}";
                };
        };
        if($content === 'p!log enable'){
            echo "status: {$log}";
            $log = 1;
            $message->reply("se ha activado el log de mensajes. contacta con <@610937299903184898> para obtener el log cuando sea requerido.");
        }
        if($content === 'p!log disable'){
                echo "status: {$log}";
                $log = 0;
                $message->reply("Se ha desactivado el log de mensajes");
            }
        try {
            $consolelog= "{$message->author->username}: {$message->content}     ".date("F j, Y, g:i a");
            echo $consolelog.PHP_EOL;
        } catch (\Throwable $th) {
            echo "error while logging: $th".PHP_EOL;
        }; 
        if($log === 1){
            if (strpos($content,'p!')=== false) {
                try {
                    $dataToLog = "a command was triggered at ".date("F j, Y, g:i a") + "    command: {$content} ";
                    echo $dataToLog.PHP_EOL;
                    $pathToFile = "log {$message->guild->name}-{$message->channel->name}.txt";    
                    $data = $dataToLog.PHP_EOL;
                    file_put_contents($pathToFile, $data, FILE_APPEND);
                } catch (\Throwable $th) {
                    echo "error while logging: $th".PHP_EOL;
                };
            } else { 
                try {
                    $dataToLog = "{$message->author->username}: {$message->content}     ".date("F j, Y, g:i a");
                    echo $dataToLog.PHP_EOL;
                    $pathToFile = ".\logs\log {$message->guild->name}-{$message->channel->name}";    
                    $data = $dataToLog.PHP_EOL;
                    file_put_contents($pathToFile.' '.date("F j, Y").'.txt',$data, FILE_APPEND);
                } catch (\Throwable $th) {
                    echo "error while logging: $th".PHP_EOL;
                };
            }
        }
        return($log);
    });
});

$discord->run();
