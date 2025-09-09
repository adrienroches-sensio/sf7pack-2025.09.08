<?php

declare(strict_types=1);

require_once __DIR__ . '/EventListenerInterface.php';
require_once __DIR__ . '/EventDispatcher.php';
require_once __DIR__ . '/Event.php';

$dispatcher = new EventDispatcher();

$dispatcher->addListener('event1', function (object $event) {
    echo 'Event 1 : Listener 1' . PHP_EOL;

    if ($event instanceof Event) {
        $event->stopPropagation();
    }
}, -500);
$dispatcher->addListener('event1', function () {
    echo 'Event 1 : Listener 2' . PHP_EOL;
}, +500);
$dispatcher->addListener('event1', function () {
    echo 'Event 1 : Listener 3' . PHP_EOL;
});
$dispatcher->addListener('event1', function () {
    echo 'Event 1 : Listener 4' . PHP_EOL;
}, -8000);

$dispatcher->dispatch(new Event(), 'event1');
