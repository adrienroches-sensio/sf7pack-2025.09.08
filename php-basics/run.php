<?php

declare(strict_types=1);

require_once __DIR__ . '/EventListenerInterface.php';
require_once __DIR__ . '/EventDispatcher.php';

$dispatcher = new EventDispatcher();

$dispatcher->addListener('event1', function () {
    echo 'Event 1 : Listener 1' . PHP_EOL;
});
$dispatcher->addListener('event1', function () {
    echo 'Event 1 : Listener 2' . PHP_EOL;
});

$dispatcher->addListener(stdClass::class, function (stdClass $event) {
    echo 'stdClass : ' . $event->name . PHP_EOL;
});

$dispatcher->dispatch(new stdClass(), 'event1');

$event2 = new stdClass();
$event2->name = 'event2';
$dispatcher->dispatch($event2);

$listener = new class implements EventListenerInterface {
    public function handle(object $event): void
    {
        echo "PLOOOOOOP : {$event->name}" . PHP_EOL;
    }
};

$dispatcher->addListener(stdClass::class, $listener);
$dispatcher->dispatch($event2);

//$dispatcher->dispatch(new stdClass(), 'noListeners');
