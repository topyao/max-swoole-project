<?php

declare(strict_types=1);

/**
 * This file is part of the Max package.
 *
 * (c) Cheng Yao <987861463@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Listeners;

use Max\Database\Events\QueryExecuted;
use Max\Event\Contracts\EventListenerInterface;
use Psr\Log\LoggerInterface;

class DatabaseQueryListener implements EventListenerInterface
{
    public function __construct(protected LoggerInterface $logger)
    {
    }

    /**
     * @return iterable
     */
    public function listen(): iterable
    {
        return [
            QueryExecuted::class,
        ];
    }

    /**
     * @param object $event
     */
    public function process(object $event): void
    {
        if ($event instanceof QueryExecuted) {
            $this->logger->get('sql')->debug($event->query, [
                'duration' => $event->duration,
                'bindings' => $event->bindings,
            ]);
        }
    }
}
