<?php
declare(strict_types = 1);

namespace NanQi\Hope\Aspect;

use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Soar;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Response;
use Hyperf\Utils\Context;
use NanQi\Hope\Helper;
use NanQi\Hope\Listener\QueryExecListener;
use Swoole\Coroutine\Channel;

/**
 * @Aspect
 */
class ResponseAspect extends AbstractAspect
{
    use Helper;

	public $classes = [
	    Response::class . '::json'
	];

    /**
	 * @param ProceedingJoinPoint $proceedingJoinPoint
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function process(ProceedingJoinPoint $proceedingJoinPoint)
	{
		$sqlKey = class_basename(QueryExecListener::class);

		if (!Context::has($sqlKey)) {
			return $proceedingJoinPoint->process();
		}

		$eventSqlList = Context::get($sqlKey);

        $response = $proceedingJoinPoint->process();

        $oldBody = json_decode($response->getBody()->getContents(), true);
        $newBody = json_encode(array_merge($oldBody, ['_sql' => $eventSqlList]), \JSON_UNESCAPED_UNICODE);

		return $response->withBody(new SwooleStream($newBody));
	}
}