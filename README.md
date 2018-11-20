# Инфобот клиент API v2

### Установка

```PHP
composer require infobot/apiv2
```

### Примеры использования

```PHP
$client = new \Infobot\Api\Client($token);
```
####  Отправка вызова

Тип вызова: static

```PHP
$message = new \Infobot\Api\Messages\StaticMessage([
   "to" => "79876543210",
   "text" => "Сообщение",
   "tts_voice" => "",
   "tts_speed" => "",
]);
$response = $client->postMessages([
    "body" => $message->toArray(),
]);
```

Тип вызова: dynamic

```PHP
$message = new \Infobot\Api\Messages\DynamicMessage([
   "to" => "79876543210",
   "scenary" => 10,
]);
$response = $client->postMessages([
    "body" => $message->toArray(),
]);
```

Тип вызова: audio

```PHP
$message = new \Infobot\Api\Messages\AudioMessage([
   "to" => "79876543210",
   "audio" => "http://examle.site.com/audio.mp3",
]);
$response = $client->postMessages([
    "body" => $message->toArray()
]);
```

#### Получение информации о пользователе (аккаунте)

```PHP
$response = $client->getUsers();
```

#### Получение списка сценариев

```PHP
$response = $client->getScenaries();
```

По страницам

```PHP
$response = $client->getScenaries([
    "query" => ["page" => 1]
]);
```

#### Получение информации о сценарии

```PHP
$response = $client->getScenaries([
    "query" => [":id" => 1]
]);
```

#### Получение значения переменных из звонка

по ID звонка

```PHP
$response = $client->getStatisticsVariables([
    "query" => ["message" => 1]
]);
```

по custom_id

```PHP
$response = $client->getStatisticsVariables([
    "query" => ["user" => 1]
]);
```

по номеру телефона

```PHP
$response = $client->getStatisticsVariables([
    "query" => ["phone" => 79876543210]
]);
```

по номеру телефона с пагинацией

```PHP
$response = $client->getStatisticsVariables([
    "query" => [
        "phone" => 79876543210,
        "page" => 1,
    ]
]);
```

#### Получить статистику по звонкам

```PHP
$response = $client->getMessages();
```

С пагинацией

```PHP
$response = $client->getMessages([
    "query" => ["page" => 1]
]);
```

информация о конкретном звонке по его id

```PHP
$response = $client->getMessages([
    "query" => [":id" => 1]
]);
```

#### Удаление (отмена) звонка из очереди

```PHP
$response = $client->deleteMessages([
    "query" => [":id" => 1]
]);
```

#### Создание и редактирование кампаний

Создать

```PHP
$campaing = new Infobot\Api\Campaigns\BaseCampaigns("Рога и Копыта");
$response = $client->postCampaigns([
    "body" => $campaing->toArray(),
]);
```

Переименовать

```PHP
$campaing = new Infobot\Api\Campaigns\BaseCampaigns("Рога и Копыта 2.0");
$response = $client->patchCampaigns([
    "query" => [":id" => 1],
    "body" => $campaing->toArray(),
]);
```

#### Получение информации о кампаниях

получение списка кампаний пользователя

```PHP
$response = $client->getCampaigns();
```

получить информацию о кампании по id

```PHP
$response = $client->getCampaigns([
    "query" => [":id" => 1]
]);
```

#### Получение финансовой статистики

```PHP
$response = $client->getStatisticsFinance([
    "query" => [
        "overall",
        ":from" => гггг-мм-дд,
        ":to" => гггг-мм-дд,
        ":campaign_id" => 10
    ]
]);
```

#### Активация услуги "Своя Связь" (для возможности использования своей SIP-телефонии)

```PHP
$response = $client->postTrunks([
    "query" => [
        "activate"
    ],
    "body" => [],
]);
```

#### Создание и управление транками

получение списка транков

```PHP
$response = $client->getTrunks();
```

получение информации по id транка

```PHP
$response = $client->getTrunks([
    "query" => [":id" => 1]
]);
```

создание транка

```PHP
$param = [
    "channels" => "10",
    "host" => "test.unknowntrunk.net",
    "login" => "admin",
    "password" => "qwerty",
    "title" => "Тестовый транк",
];
$trunk = new \Infobot\Api\Trunks\BaseTrunk($param);
$response = $client->postTrunks([
    "body" => $trunk->toArray(),
]);
```

удаление транка

```PHP
$response = $client->deleteTrunks([
    "query" => [":id" => 1]
]);
```
 
обновление транка

```PHP
$param = [
    "channels" => "10",
    "host" => "test.unknowntrunk.net",
    "login" => "admin",
    "password" => "qwerty",
    "title" => "Тестовый транк",
];
$trunk = new \Infobot\Api\Trunks\BaseTrunk($param);
$response = $client->patchTrunks([
    "query" => [":id" => 1],
    "body" => $trunk->toArray(),
]);
```

### Управление рассылками

Список рассылок

```PHP
$response = $client->getDeliveries();
```

По страницам

```PHP
$response = $client->getDeliveries([
    "query" => ["page" => 1]
]);
```

Информация по рассылке

```PHP
$response = $client->getDeliveries([
    "query" => [":id" => 1]
]);
```

Запустить рассылку

```PHP
$response = $client->postDeliveries([
    "query" => [":id" => 1],
    "body" => [],
]);
```

Приостановить рассылку

```PHP
$response = $client->postDeliveries([
    "query" => [":id" => 1],
    "body" => [],
]);
```

Создать рассылку

```PHP
$params = [
    "aon" => 79876543210,
    "campaign_id" => 1,
    "client_timezone" => true,
    "d_type" => static,
    "detect_voicemail" => false,
    "group_id" => 1,
    "message" => "static text",
    "messages_per_packet" => 2,
    "name" => "Моя рассылка",
    "pause_between_packet" => 10,
    "scenary_id" => '',
    "speed" => 10,
    "time_to_send_start" => "10:00",
    "time_to_send_end" => "20:00",
    "trunk" => 12,
    "try_count" => 2,
    "try_timeout" => 10,
    "tts_speed" => 10,
    "voice" => "male",
    "file" => ''
];

$response = $client->postDeliveries([
    "body" => $params,
]);
```

Изменить рассылку

```PHP
$params = [
    "aon" => 79876543210,
    "campaign_id" => 1,
    "client_timezone" => true,
    "d_type" => static,
    "detect_voicemail" => false,
    "group_id" => 1,
    "message" => "static text",
    "messages_per_packet" => 2,
    "name" => "Моя рассылка",
    "pause_between_packet" => 10,
    "scenary_id" => '',
    "speed" => 10,
    "time_to_send_start" => "10:00",
    "time_to_send_end" => "20:00",
    "trunk" => 12,
    "try_count" => 2,
    "try_timeout" => 10,
    "tts_speed" => 10,
    "voice" => "male",
    "file" => ''
];

$response = $client->patchDeliveries([
    "query" => [":id" => 1],
    "body" => $params,
]);
```


### Управление группами


Список групп

```PHP
$response = $client->getGroups();
```

По страницам

```PHP
$response = $client->getGroups([
    "query" => ["page" => 1]
]);
```

Информация по группе

```PHP
$response = $client->getGroups([
    "query" => [":id" => 1]
]);
```

Создать группу
```PHP
$params = [
    "name" => "Имя группы"
];

$response = $client->postGroups([
    "body" => $params,
]);
```


Обновить группу

```PHP
$params = [
    "name" => "Имя группы"
];

$response = $client->patchGroups([
    "query" => [":id" => 1],
    "body" => $params,
]);
```

### Управление контактами


Список контактов

```PHP
$response = $client->getContacts();
```

По страницам

```PHP
$response = $client->getContacts([
    "query" => ["page" => 1]
]);
```

Информация по контакту

```PHP
$response = $client->getContacts([
    "query" => [":id" => 1]
]);
```

Список контактов по группе

```PHP
$response = $client->getContacts([
    "query" => [
        "group",
        ":group_id" => 1
    ]
]);
```

По страницам

```PHP
$response = $client->getContacts([
    "query" => [
        "group",
        ":group_id" => 1,
        "page" => 1
    ]
]);
```


Создать контакт
```PHP
$params = [
    "sex" => "male",
    "group_ids" => [1,2,3],
    "email" => "email@email.email",
    "fname" => "Фамилия",
    "lname" => "Имя",
    "mname" => "Отчество",
    "phone" => "79876543210",
    "var_1" => "var",
    "var_2" => "var",
    "var_3" => "var",
    "var_4" => "var",
    "var_5" => "var",
];

$response = $client->postContacts([
    "body" => $params,
]);
```


Обновить контакт

```PHP
$params = [
    "sex" => "male",
    "group_ids" => [1,3],
    "email" => "email@email.email",
    "fname" => "Фамилия",
    "lname" => "Имя",
    "mname" => "Отчество",
    "phone" => "79876543210",
    "var_1" => "var",
    "var_2" => "var",
    "var_3" => "var",
    "var_4" => "var",
    "var_5" => "var",
];

$response = $client->patchContacts([
    "query" => [":id" => 1],
    "body" => $params,
]);
```
