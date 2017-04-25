<?php

namespace flyandi\Monolog\Handler;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class SplunkHandler extends AbstractProcessingHandler
{
    /**
     * @var string
     */
    private $source = false;

    /**
     * @var array
     */
    private $connectionParams = false;

    /**
     * @var array
     */
    private $optionalParams = false;

    /**
     * SplunkHandler constructor.
     * @param int $source
     * @param bool $connectionParams
     * @param bool $optionalParams
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($source, $connectionParams = false, $optionalParams = false, $level = Logger::INFO, $bubble = true)
    {
        $this->source = $source;
        $this->connectionParams = $connectionParams;
        $this->optionalParams = $optionalParams;

        parent::__construct($level, $bubble);
    }

    /**
     * @inherited
     * @param array $record
     */
    public function write(array $record)
    {
        $this->send((string) $record['formatted']);
    }

    /**
     * @param $message
     * @return bool|void
     */
    protected function send($message)
    {
        try {
            $splunkService = new \Splunk_Service($this->connectionParams);
            $splunkService->login();

            $params = [
                'source'     => $this->project,
                'sourcetype' => 'json_auto_timestamp',
                'host'       => gethostname() ?: null,
            ];

            if(is_array($this->optionalParams)) $params = array_merge($this->optionalParams, $params);

            $splunkReceiver = $splunkService->getReceiver();
            $result = $splunkReceiver->submit($message, $params);

            return $result;

        } catch (Exception $e) {

            var_dump($e->getMessage());
        }

        return true;
    }

    /**
     * @inheritdoc
     * @inherited
     * @return JsonFormatter
     */
    protected function getDefaultFormatter()
    {
        return new JsonFormatter();
    }
}
