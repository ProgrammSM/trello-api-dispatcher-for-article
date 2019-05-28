<?php

/**
 * Интерфейс сервиса подключения к API Trello.
 */
interface TrelloApiServiceInterface
{
    /**
     * Url к Api.
     *
     * @return mixed
     */
    public function getUrl();

    /**
     * Включение заголовков в вывод.
     *
     * @return int
     */
    public function isCurlOptHeaderEnable(): int;

    /**
     * Результат запроса в виде строки, вместо вывода в браузер.
     *
     * @return int
     */
    public function isSetReturnTransfer(): int;

    /**
     * Время до отсоединения по таймауту в секундах.
     *
     * @return mixed
     */
    public function getTimeout();

    /**
     * Код ответа.
     *
     * @return mixed
     */
    public function getCodeResponse();

    /**
     * Ответ.
     *
     * @return null|string
     */
    public function getResponse(): ?string;

    /**
     * Установить конфигурацию подключения.
     *
     * @param array $config Конфигурация
     */
    public function setConfig($config): void;

    /**
     * Выполнить POST-запрос.
     *
     * @param mixed $param Параметры тела POST-запроса
     *
     * @return mixed
     */
    public function sendPost($param): void;
}
