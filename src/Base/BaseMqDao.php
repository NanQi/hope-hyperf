<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\AsyncQueue\Driver\DriverFactory;
use NanQi\Hope\Helper;
use NanQi\Hope\Queue\JobProducer;

abstract class BaseMqDao extends BaseDao
{
    use Helper;

    /**
     * 投递消息
     * @param JobProducer $job
     * @param int $delay
     * @param string $channel
     * @return bool
     */
    public function produce(JobProducer $job, int $delay = 0, string $channel = 'default') : bool
    {
        /** @var DriverFactory $driverFactory */
        $driverFactory = di(DriverFactory::class);
        return $driverFactory->get($channel)->push($job, $delay);
    }
}
