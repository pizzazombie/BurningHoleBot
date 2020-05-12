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

    //buttons
    $bot->command("buttons", function ($message) use ($bot) {
        $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
            [
                [
                    ['callback_data' => 'data_test', 'text' => 'Заказать вино'],
                    ['callback_data' => 'data_test2', 'text' => 'писюлька Коляна'],
                    ['callback_data' => 'data_test3', 'text' => 'То самое видео']
                ]
            ]
        );
    
        $bot->sendMessage($message->getChat()->getId(), "Это кнопки, я буду их постепенно развивать, а пока только это", false, null,null,$keyboard);
    });

    //обработка кнопок
    $bot->on(function($update) use ($bot, $callback_loc, $find_command){
        $callback = $update->getCallbackQuery();
        $message = $callback->getMessage();
        $chatId = $message->getChat()->getId();
        $data = $callback->getData();
        
        if($data == "data_test"){
            $bot->answerCallbackQuery( $callback->getId(), "5л чертовски офигенного вина заказаны! (на самом деле нет, но я работаю над этим)",true);
        }
        if($data == "data_test2"){
            $bot->sendMessage($chatId, "Писюлька @kolka_bondik в порядке!");
            $bot->answerCallbackQuery($callback->getId()); // можно отослать пустое, чтобы просто убрать "часики" на кнопке
        }
        if($data == "data_test3"){
            $bot->sendMessage($chatId, "https://vk.com/pizzazombie?z=video16687567_456239325%2Fvideos16687567%2Fpl_16687567_-2");
            $voice =  new \CURLFile('src/sasha i love you.mp3');
            $bot->sendDocument(
                $message->getChat()->getId(),
                $voice //,
                //$duration,
                //$replyToMessageId,
                //$replyMarkup,
                //$disableNotification
                );
            $bot->answerCallbackQuery($callback->getId()); // можно отослать пустое, чтобы просто убрать "часики" на кнопке
        }
    
    }, function($update){
        $callback = $update->getCallbackQuery();
        if (is_null($callback) || !strlen($callback->getData()))
            return false;
        return true;
    });


    // помощь
    $bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
    /help - помощь
    /buttons - показать всякие кнопочки

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
    /SashaILoveYou - вы сами знаете.)
    ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
    });
    //прочие команды

    $bot->command('HowIsBondar', function ($message) use ($bot) {
        $answer = 'Коля остался в петушках.....';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsLev', function ($message) use ($bot) {
        $answer = 'Лев переделывает Бота';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsMary', function ($message) use ($bot) {
        $answer = 'Маша всё еще рисует вам зин';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsPipir', function ($message) use ($bot) {
        $answer = 'Пипирка дома и хочет в руль';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsMel', function ($message) use ($bot) {
        $answer = 'Мел не бреется уже n + 1 дней';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowisMel', function ($message) use ($bot) {
        $answer = 'Мел не бреется уже n + 1 дней';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsKapusta', function ($message) use ($bot) {
        $answer = 'Кепыч тиран и плохо кушает сосисочки.(';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('HowIsAnn', function ($message) use ($bot) {
        $answer = 'Аня считает котиков';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });
    $bot->command('LastTrack', function ($message) use ($bot) {
        $voice =  new \CURLFile('src/underworld.mp3');
        $bot->sendDocument(
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
    $bot->command('voice', function ($message) use ($bot) {
        $voice =  new \CURLFile('src/bond.mp3');
        $bot->sendVoice(
            $message->getChat()->getId(),
            $voice //,
            //$duration,
            //$replyToMessageId,
            //$replyMarkup,
            //$disableNotification
            );
       // $answer = 'Это свежайший';
       // $bot->sendMessage($message->getChat()->getId(), $answer);
        });

    $bot->command('SashaILoveYou', function ($message) use ($bot) {
        $voice =  new \CURLFile('src/sasha i love you.mp3');
        $bot->sendDocument(
            $message->getChat()->getId(),
            $voice //,
            //$duration,
            //$replyToMessageId,
            //$replyMarkup,
            //$disableNotification
            );
        $answer = 'Саша! Я люблю тебя!';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        $bot->sendMessage($chatId, "https://vk.com/pizzazombie?z=video16687567_456239325%2Fvideos16687567%2Fpl_16687567_-2");
        });

    $bot->command('HowIsBot', function ($message) use ($bot) {
        $answer = 'Спасибо, что спросили! Тут, в облачном хранилище телеграма как-то жутковато, но я не унываю!)';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        });

    $bot->command('rss', function ($message) use ($bot) {
        $answer = 'вот что мне удалось найти';
        $bot->sendMessage($message->getChat()->getId(), $answer);
        $answer = 'статьи:';
        $bot->sendMessage($message->getChat()->getId(), $answer);

        if (file_exists('https://lenta.ru/rss/news.xml')) {
            //$xml = simplexml_load_file('test.xml');
            $answer = 'файл найден';
        } else {
            $answer = 'Не удалось открыть файл test.xml.';
        }
     //   $html=simplexml_load_file('http://nplus1.ru/rss');
        
		$bot->sendMessage($message->getChat()->getId(), $answer);

        });
    // $bot->command('Nplus1', function ($message) use ($bot) {
    //     $html=simplexml_load_file('https://nplus1.ru/rss');
    //     foreach ($html->channel->item as $item) {
    //         $answer .= "\xE2\x9E\xA1 ".$item->title." (<a href='".$item->link."'>читать</a>)\n";
    //            }
    //            $bot->sendMessage([$message->getChat()->getId(),$answer ]);
    //            $bot->sendMessage($message->getChat()->getId(), 'это должна быть ссылкa');

       // $bot->sendMessage([ 'chat_id' => $message->getChat()->getId(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $answer ]);
        //$answer = 'Спасибо, что спросили! Тут, в облачном хранилище телеграма как-то жутковато, но я не унываю!)';
       // $bot->sendMessage($message->getChat()->getId(), $answer);
      


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

