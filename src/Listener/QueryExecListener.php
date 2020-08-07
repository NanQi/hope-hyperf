<?php

declare(strict_types = 1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace NanQi\Hope\Listener;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Database\Events\QueryExecuted;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Context;
use Hyperf\Utils\Str;
use NanQi\Hope\Helper;

/**
 * @Listener
 */
class QueryExecListener implements ListenerInterface
{
    use Helper;

	public function listen() : array
	{
		return [
			QueryExecuted::class,
		];
	}

	/**
	 * @param object $event
	 */
	public function process(object $event) : void
	{
	    $isProd = $this->isProduct();
		if ($event instanceof QueryExecuted && !$isProd) {
            $sql = $event->sql;
            if (! Arr::isAssoc($event->bindings)) {
                foreach ($event->bindings as $key => $value) {
                    $sql = Str::replaceFirst('?', "'{$value}'", $sql);
                }
            }
			$eventSqlList   = (array)Context::get(class_basename(__CLASS__));
			$eventSqlList[] = $sql;
			Context::set(class_basename(__CLASS__), $eventSqlList);
		}
	}
}
