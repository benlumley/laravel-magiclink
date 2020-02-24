<?php


namespace MagicLink\Test\Events;

use Illuminate\Support\Facades\Event;
use MagicLink\Actions\ResponseAction;
use MagicLink\Events\MagicLinkWasVisited;
use MagicLink\MagicLink;
use MagicLink\Test\TestCase;

class MagicLinkWasVisitedTest extends TestCase
{
    public function test_event_dispatched_when_link_is_visited()
    {
        Event::fake([
            MagicLinkWasVisited::class
        ]);

        $magiclink = MagicLink::create(new ResponseAction());

        $this->get($magiclink->url);

        Event::assertDispatched(
            MagicLinkWasVisited::class,
            function (MagicLinkWasVisited $event) use ($magiclink) {
                return $magiclink->id === $event->magiclink->id &&
                    $event->magiclink->num_visits === 1;
            }
        );
    }
}