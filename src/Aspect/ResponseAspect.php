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
use NanQi\Hope\Hope;
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

	const SOAR_PATH = "vendor/bin/soar";

    /**
     * @var Soar
     */
	protected $soar;

	public function __construct()
    {
        $config = [
            // 下载的 soar 的路径
            '-soar-path' => self::SOAR_PATH,
            // 测试环境配置
            '-test-dsn' => [
                'host' => env('DB_HOST', 'localhost'),
                'port' => env('DB_PORT', 3306),
                'dbname' => env('DB_DATABASE', 'hope'),
                'username' => env('DB_USERNAME', 'homestead'),
                'password' => env('DB_PASSWORD', 'secret'),
            ],
            // 日志输出文件
            '-log-output' => './soar.log',
            // 报告输出格式: 默认  markdown [markdown, html, json]
            '-report-type' => 'json',
        ];
        try {
            $this->soar = new Soar($config);
        } catch (InvalidConfigException $e) {
        }
    }

    /**
	 * @param ProceedingJoinPoint $proceedingJoinPoint
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function process(ProceedingJoinPoint $proceedingJoinPoint)
	{
	    if ($this->isProduct() || !file_exists(self::SOAR_PATH)) {
            return $proceedingJoinPoint->process();
        }

		$sqlKey = class_basename(QueryExecListener::class);

		if (!Context::has($sqlKey)) {
			return $proceedingJoinPoint->process();
		}

		$eventSqlList = Context::get($sqlKey);

		$explains = [];
		$channel  = new Channel();

		foreach ($eventSqlList as $sql) {
			co(function () use ($sql, $channel) {
				$explain = [];
				$soar    = $this->soar->score($sql);
                $explain['sql']     = $sql;
                $explain['explain'] = json_decode($soar, true);
				$channel->push($explain);
			});
			$explains[] = $channel->pop();
		}

		$response = $proceedingJoinPoint->process();

		$oldBody = json_decode($response->getBody()->getContents(), true);
		$newBody = json_encode(array_merge($oldBody, ['soar' => $explains]), \JSON_UNESCAPED_UNICODE);

		return $response->withBody(new SwooleStream($newBody));
	}
}