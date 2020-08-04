<?php


namespace NanQi\Hope\Controller;


use NanQi\Hope\Base\BaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

/**
 * @Controller()
 * Class HealthCheckController
 * @package NanQi\Hope\Controller
 */
class MetricsController extends BaseController
{
    /**
     * @RequestMapping(path="/metrics")
     * @param CollectorRegistry $registry
     * @return string
     */
    public function metrics(CollectorRegistry $registry)
    {
        $renderer = new RenderTextFormat();
        $res =  $renderer->render($registry->getMetricFamilySamples());
        var_dump($res);
    }
}