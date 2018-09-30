#Инфобот клиент API v2

###Установка

```PHP
composer require infobot/apiv2
```

###Примеры использования

```PHP
$client = new \Infobot\Api\Client($token);
```
#####Отправка вызова

Тип вызова: static
```PHP
$message = new \Infobot\Api\Messages\StaticMessage([
   "to" => "79876543210",
   "text" => "Сообщение",
   "tts_voice" => "",
   "tts_speed" => "",
]);
$params = [
    "body" => $message->toArray();
]
$response = $client->postMessages($params)
```

Тип вызова: dynamic
```PHP
$message = new \Infobot\Api\Messages\DynamicMessage([
   "to" => "79876543210",
   "scenary" => 10,
]);
$params = [
    "body" => $message->toArray();
]
$response = $client->postMessages($params)
```

Тип вызова: audio
```PHP
$message = new \Infobot\Api\Messages\AudioMessage([
   "to" => "79876543210",
   "audio" => "http://examle.site.com/audio.mp3",
]);
$params = [
    "body" => $message->toArray();
]
$response = $client->postMessages($params)
```

#####Получение информации о пользователе (аккаунте)

```PHP
$response = $client->getUsers();
```

#####Получение списка сценариев

```PHP
$response = $client->getScenaries();
```
По страницам
```PHP
$response = $client->getScenaries([
    "getParams" => ["page" => 1]
]);
```

#####Получение информации о сценарии

```PHP
$response = $client->getScenaries([
    "getParams" => [":id" => 1]
]);
```

#####Получение значения переменных из звонка

```PHP
$response = $client->getScenaries([
    "getParams" => [":id" => 1]
]);
```

#####Получение значения переменных из звонка
по ID звонка
```PHP
$response = $client->getStatisticsVariables([
    "getParams" => ["message" => 1]
]);
```

по custom_id
```PHP
$response = $client->getStatisticsVariables([
    "getParams" => ["user" => 1]
]);
```

по номеру телефона
```PHP
$response = $client->getStatisticsVariables([
    "getParams" => ["phone" => 79876543210]
]);
```

по номеру телефона с пагинацией
```PHP
$response = $client->getStatisticsVariables([
    "getParams" => [
        "phone" => 79876543210,
        "page" => 1,
    ]
]);
```

#####Получить статистику по звонкам

```PHP
$response = $client->getMessages();
```
С пагинацией
```PHP
$response = $client->getMessages([
    "getParams" => ["page" => 1]
]);
```

информация о конкретном звонке по его id

```PHP
$response = $client->getMessages([
    "getParams" => [":id" => 1]
]);
```

#####Создание и редактирование кампаний

Создать

```PHP
$campaing = new Infobot\Api\Campaigns\BaseCampaigns("Рога и Копыта");
$response = $client->postCampaigns([
    "body" => $campaing->toArray();
]);
```

Переименовать
```PHP
$campaing = new Infobot\Api\Campaigns\BaseCampaigns("Рога и Копыта");
$response = $client->patchCampaigns([
    "getParams" => [":id" => 1],
    "body" => $campaing->toArray();
]);
```

#####Получение информации о кампаниях

получение списка кампаний пользователя
```PHP
$response = $client->getCampaigns();
```

получить информацию о кампании по id
```PHP
$response = $client->getCampaigns([
    "getParams" => [":id" => 1]
]);
```

#####Получение финансовой статистики

```PHP
$response = $client->getStatisticsFinance([
    "getParams" => [
        "overall",
        ":from" => гггг-мм-дд,
        ":to" => гггг-мм-дд,
        ":campaign_id" => 10
    ]
]);
```

#####Активация услуги "Своя Связь" (для возможности использования своей SIP-телефонии)

```PHP
$response = $client->getTrunks([
    "getParams" => [
        "activate"
    ]
]);
```

#####Создание и управление транками

получение списка транков

```PHP
$response = $client->getTrunks();
```

получение информации по id транка

```PHP
$response = $client->getTrunks([
    "getParams" => [":id" => 1]
]);
```

создание транка

```PHP
$param = [
    "channels" => "",
    "host" => "",
    "login" => "",
    "password" => "",
    "title" => "",
]
$trunc = new \Infobot\Api\Truncs\BaseTrunc($param);
$response = $client->postTrunc([
    "body" => $trunc->toArray();
]);
```

удаление транка

 ```PHP
 $response = $client->deleteTrunc([
     "getParams" => [":id" => 1]
 ]);
 ```
 
 обновление транка
 
  ```PHP
  $param = [
      "channels" => "",
      "host" => "",
      "login" => "",
      "password" => "",
      "title" => "",
  ]
  $trunc = new \Infobot\Api\Truncs\BaseTrunc($param);
  $response = $client->patchTrunc([
      "getParams" => [":id" => 1],
      "body" => $trunc->toArray(),
  ]);
  ```