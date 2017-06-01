<?php

namespace Request;

use BrowscapPHP\Browscap;
use GeoIp2\Database\Reader;

/**
 * Class Request
 * @package Request
 * @property Information $Information
 */
final class Request
{

    private $Browscrap;
    private $Ip;
    private $Record;
    public $Information;

    public function __construct()
    {
        $this->Browscrap = new Browscap();
        $this->Ip = new Ip();
        $this->Information = new Information();

        if ($this->Ip->client() != '::1' || $this->Ip->client() != '127.0.0.1') {
            $reader = new Reader(__DIR__ . '/database.txt');
            $this->Record = $reader->city($this->Ip->client());
        }

        $browser = $this->Browscrap->getBrowser();
        $this->Information->Ip = $this->Ip->client();
        $this->Information->Country = isset($this->Record) ? $this->Record->country->name : NULL;
        $this->Information->City = isset($this->Record) ? $this->Record->city->name : NULL;
        $this->Information->Browser = $browser->parent;
        $this->Information->Os = $browser->platform;
        $this->Information->Date = date('Y-m-d');
        $this->Information->Hour = date('H:i:s');
    }
}