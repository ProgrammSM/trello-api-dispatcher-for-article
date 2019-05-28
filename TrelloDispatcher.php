<?php

/**
 * Диспетчер Trello.
 */
class TrelloDispatcher
{
    /**
     * @var string Url к api trello.com.
     */
    private const URL_API = 'https://api.trello.com/1/';

    /**
     * @var string Персональный ключ для доступа к API.
     */
    private $_apiKey;

    /**
     * @var string Token для доступа к Trello.
     */
    private $_token;

    /**
     * @var TrelloApiServiceInterface Сервис для отправки отправки запросов к Trello
     */
    private $_service;

    /**
     * TrelloDispatcher constructor.
     *
     * @param string                    $apiKey  Ключ к Api
     * @param string                    $token   Token Trello
     * @param TrelloApiServiceInterface $service Реализация сервиса
     */
    public function __construct(string $apiKey, string $token, TrelloApiServiceInterface $service)
    {
        $this->_apiKey = $apiKey;
        $this->_token = $token;
        $this->_service = $service;
    }

    /**
     * Создать карточку.
     * 
     * @param string|int $listId      Идентификатор списка (колонки)
     * @param string     $name        Заголовок карточки
     * @param string     $description Описание карточки
     *
     * @return string|null
     */
    public function createCard($listId, $name, $description): ?string
    {
        $body = "idList=$listId&name=$name&desc=$description";
        $this->_service->setConfig(['url' => $this->createUrl('card')]);
        $this->_service->sendPost($body);

        return $this->_service->getResponse();
    }

    /**
     * Обязательные параметры при запросе.
     * 
     * @return string
     */
    private function getParamsRequired(): string
    {
        return "key={$this->_apiKey}&token={$this->_token}";
    }

    /**
     * Создать Url.
     *
     * @param string     $entityName Название сущности
     * @param array|null $params     Параметры GET
     *
     * @return string
     */
    private function createUrl(string $entityName, array $params = null): string
    {
        $paramsGet = '';
        if (null !== $params) {
            $paramsGet = '&' . implode('&', array_map(
                static function ($value, $key) {
                    return "{$key}={$value}";
                },
                array_keys($params),
                $params
            ));
        }

        return self::URL_API . "{$entityName}?{$this->getParamsRequired()}{$paramsGet}";
    }
}
