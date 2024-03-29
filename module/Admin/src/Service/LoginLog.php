<?php

namespace Admin\Service;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Log\Processor;
use Laminas\Log\Logger;
use Laminas\Log\Writer;

class LoginLog
{
    private Logger $loggr;
    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->loggr = new Logger();
        $this->confSent();
    }

    private function confSent()
    {
        $conf = [
            'timestamp' => 'czas',
            'message' => 'czyZalogowany',
            'extra' => [
                'ip' => 'ip',
                'date' => 'data'
            ],
        ];
        
        $processor = new Processor\PsrPlaceholder();
        $this->loggr->addProcessor($processor);
        $writer = new Writer\Db($this->adapter, 'logowanie', $conf);
        $this->loggr->addWriter($writer);

    }

    public function SentInfo($message)
    {
        $this->loggr->info($message, ['ip' => $_SERVER['REMOTE_ADDR'], 'date' => date("Y-m-d")]);
    }
}
?>