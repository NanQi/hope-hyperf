<?php


namespace NanQi\Hope\Controller;


use NanQi\Hope\Base\BaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 * Class HealthCheckController
 * @package NanQi\Hope\Controller
 */
class HealthCheckController extends BaseController
{
    /**
     * @RequestMapping(path="/liveness",methods="get,head")
     * @return string
     */
    public function liveness()
    {
        return 'ok';
    }

    /**
     * @RequestMapping(path="/readiness",methods="get,head")
     * @return string
     */
    public function readiness()
    {
        return 'ok';
    }
}