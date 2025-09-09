<?php

declare(strict_types=1);

final class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener, int $priority = 0): void
    {
        $this->listeners[$eventName] ??= [];

        if ($listener instanceof EventListenerInterface) {
            $this->listeners[$eventName][] = [$listener->handle(...), $priority];
        } else {
            $this->listeners[$eventName][] = [$listener, $priority];
        }
    }

    public function dispatch(object $event, string|null $eventName = null): object
    {
        $eventName ??= $event::class;
        $listeners = $this->listeners[$eventName] ?? [];

        if (count($listeners) === 0) {
            throw new LogicException('No listeners registered for event ' . $eventName . '.');
        }

        usort($listeners, function (array $a, array $b) {
            [$listenerA, $priorityA] = $a;
            [$listenerB, $priorityB] = $b;

            return $priorityB <=> $priorityA;
        });

        foreach ($listeners as [$listener]) {
            if ($event instanceof Event && $event->isPropagationStopped()) {
                break;
            }

            $listener($event);
        }

        return $event;
    }
}
