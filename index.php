<?php
header('Content-Type: text/html; charset=utf-8');
// подключаемся к API
require_once("vendor/autoload.php");
// создаем переменную бота
$token = "1206590134:AAGNW2hP9bUM0LztTSMmBmlMPq5jbT0FnkY";
$bot = new \TelegramBot\Api\Client($token);

if(!file_exists("registered.trigger")){
    /**
    * файл registered.trigger будет создаваться после регистрации бота.
    * если этого файла не существует, значит бот не
    * зарегистрирован в Телеграмм
    */
    // URl текущей страницы
    $page_url = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    $result = $bot->setWebhook($page_url);
    if($result){
    file_put_contents("registered.trigger",time()); // создаем файл дабы остановить повторные регистрации
    }
    }

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Привет! Список команд можно увидеть по команде /help
    ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
    });
    // помощь
    $bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
    /help - помощь

    Личное:
    /HowIsBondar
    /HowIsLev
    /HowIsMary
    /HowIsPipir
    /HowIsMel
    /HowIsAnn
    /HowIsKapusta

    Прочее:
    /LastTrack - последний трек Льва
    ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
    });
    //прочие команды

    $bot->command('HowIsBondar', function ($message) use ($bot) {
        $answer = 'Писюлька Коляна в порядке, проверено';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsLev', function ($message) use ($bot) {
        $answer = 'Лев чувствует себя хорошо, но ему не хватает своих друзей';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsMary', function ($message) use ($bot) {
        $answer = 'Маша рисует вам зин';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsPipir', function ($message) use ($bot) {
        $answer = 'Если Пипирка не на работе, то значит она в Руле, как обычно!';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsMel', function ($message) use ($bot) {
        $answer = 'Мел увлекся нигилизмом, кто-нибудь спасите его';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowisMel', function ($message) use ($bot) {
        $answer = 'Мел увлекся нигилизмом, кто-нибудь спасите его';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsKapusta', function ($message) use ($bot) {
        $answer = 'Кепыч лучший, но у него воняет из ротика';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsAnn', function ($message) use ($bot) {
        $answer = 'Аня считает котиков';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('LastTrack', function ($message) use ($bot) {
        $voice =  new \CURLFile('src/underworld.mp3');
        $bot->sendVoice(
            $message->getChat()->getId(),
            $voice //,
            //$duration,
            //$replyToMessageId,
            //$replyMarkup,
            //$disableNotification
            );
        $answer = 'Это свежайший';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsBot', function ($message) use ($bot) {
        $answer = 'Спасибо, что спросили! Тут, в облачном хранилище телеграма как-то жутковато, но я не унываю!)';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });


//чекаем все сообщения чата!
    $bot->on(function($Update) use ($bot){
        $message = $Update->getMessage();
        $mtext = $message->getText();
        $cid = $message->getChat()->getId();
        if(mb_stripos($mtext,"привет") !== false){
            $bot->sendMessage($message->getChat()->getId(), "Привет, чувак!");
        }
        else if(mb_stripos($mtext,"Бонд") !== false){
            $bot->sendMessage($message->getChat()->getId(), "Саша Андрюшин, кстати, просил передать, что Бонд - шлюха");
        }
        else if(mb_stripos($mtext,"дела") !== false){
            $bot->sendMessage($message->getChat()->getId(), "О, спросите у меня тоже как дела!
            Это можно сделать с помощью команды /HowIsBot");
        }
        else if(mb_stripos($mtext,"Вино") !== false){
            $bot->sendMessage($message->getChat()->getId(), "Ира, похоже, пора снова заказывать 5л.)");
        }
        else if(mb_stripos($mtext,"винишко") !== false){
            $bot->sendMessage($message->getChat()->getId(), "Так, пора делать команду для меня для автоматического дозаказа вина.)");
        }
        else if(mb_stripos($mtext,"гей") !== false){   
            $pic = "https://rtvi.com/upload/iblock/a83/a838c6726e325726b6703fb90b3127b1.jpg";
            $bot->sendPhoto($message->getChat()->getId(), $pic);
        }
        }, function($message) use ($name){
        return true; // когда тут true - команда проходит
        });


    
    // запускаем обработку
    $bot->run();

