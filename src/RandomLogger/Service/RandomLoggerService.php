<?php
namespace RandomLogger\Service;

use RandomLogger\Request\RandomLoggerRequest;
use Faker;

class RandomLoggerService
{
    /** @var RandomLoggerRequest */
    private $request;

    private $dir = '/var/log/randomLogger';

    private $file;

    /**
     * RandomLoggerService constructor.
     * @param RandomLoggerRequest $request
     */
    public function __construct(RandomLoggerRequest $request)
    {
        $this->request = $request;
        $this->file = $this->dir . '/' . $this->request->type() . '.log';
        $this->init();
    }

    public function doLog()
    {
        return $this->{"do" . ucfirst($this->request->type()) . "Log"}();
    }

    private function init()
    {
        date_default_timezone_set('UTC');
        
        if (!is_dir($this->dir)) {
            throw new \Exception('No existe la carpeta ' . $this->dir);
        }

        if (!is_writable($this->dir)) {
            throw new \Exception('La carpeta ' . $this->dir . ' no tiene permisos de escritura');
        }

        if (!is_file($this->file)) {
            touch($this->file);
        }
    }

    private function write($data)
    {
        file_put_contents($this->file, $data . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    private function doBackofficeLog()
    {
        $faker = Faker\Factory::create();
        $data = implode(' ' , array($this->getDate(), 'symfony', $this->getLogType(), $this->getApplicationType(), $faker->text()));

        $this->write($data);

        return $data;
    }

    private function doFrontendLog()
    {
        return $this->doBackofficeLog();
    }

    private function doNegocioLog()
    {
        $multiplicador = (1==rand(1,20)?-1:1);
        $data = implode(' ' , array($this->getCompleteDate(), 'comanda', '[notice]', $this->getProductType(),
            rand(2000, 20000)/100*$multiplicador));

        $this->write($data);

        return $data;
    }

    private function doNice2Log()
    {
        $faker = Faker\Factory::create();
        $data = implode(' ' , array('[' . $this->getDate() . ']', $this->getSymfony2ApplicationType() . ':',
            str_replace('z', PHP_EOL, $faker->realText(200, 1)), '[]', '[]'));

        $this->write($data);

        return $data;
    }

    private function getDate()
    {
        return date('M d H:i:s');
    }

    private function getCompleteDate()
    {
        return date('Y-m-d H:i:s');
    }

    private function getLogType()
    {
        $logTypes = array('[alert]', '[warning]');

        return $logTypes[rand(0, count($logTypes) - 1)];
    }

    private function getProductType()
    {
        $productTypes = array('venta-privada', 'stock-propio', 'unico', 'unico-stock-propio', 'ocio', 'escapada', 'nice', 'compra-express');

        return $productTypes[rand(0, count($productTypes) - 1)];
    }

    private function getApplicationType()
    {
        $applicationTypes = array('{PHP}', '{Exception}');

        return $applicationTypes[rand(0, count($applicationTypes) - 1)];
    }

    private function getSymfony2ApplicationType()
    {
        $type01 = array('request', 'app');
        $type02 = array('CRITICAL', 'ERROR', 'INFO');

        return $type01[rand(0, count($type01) - 1)] . '.' . $type02[rand(0, count($type02) - 1)];
    }

}
