<?php

require_once 'TrelloApiServiceInterface.php';

/**
 * Сервис для работы с API Trello.
 */
class TrelloApiService implements TrelloApiServiceInterface
{
    /**
     * @var string Url API.
     */
    private $_url;

    /**
     * @var int Включение заголовков в вывод.
     */
    private $_isCurlOptHeaderEnable = 1;

    /**
     * @var bool Результат запроса в виде строки вместо вывода в браузер.
     */
    private $_isReturnTransfer = true;

    /**
     * @var int Время до отсоединения по таймауту в секундах.
     */
    private $_timeout = 10;

    /**
     * @var string Ответ сервиса.
     */
    private $_response;

    /**
     * @var int Код ответа.
     */
    private $_responseCode;

    /**
     * {@inheritDoc}
     */
    public function setConfig($config): void
    {
        foreach ($config as $propertyName => $value) {
            $property = "_$propertyName";
            $this->$property = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * {@inheritDoc}
     */
    public function isCurlOptHeaderEnable(): int
    {
        return $this->_isCurlOptHeaderEnable;
    }

    /**
     * {@inheritDoc}
     */
    public function isSetReturnTransfer(): int
    {
        return $this->_isReturnTransfer;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }

    /**
     * {@inheritDoc}
     */
    public function getCodeResponse()
    {
        return $this->_responseCode;
    }

    /**
     * {@inheritDoc}
     */
    public function getResponse(): ?string
    {
        return $this->_response;
    }

    /**
     * {@inheritDoc}
     */
    public function sendPost($param): void
    {
        $curl = $this->getCurl();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $this->_response = curl_exec($curl);
        $this->_responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    /**
     * Curl с установкой общих опций.
     *
     * @return false|resource
     */
    private function getCurl()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());
        curl_setopt($curl, CURLOPT_HEADER, $this->isCurlOptHeaderEnable());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, $this->isSetReturnTransfer());
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->getTimeout());

        return $curl;
    }
}
