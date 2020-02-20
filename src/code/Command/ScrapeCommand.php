<?php

namespace TickX\Scraper\Command;

use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TickX\Scraper\Model\Event;
use TickX\Scraper\Model\Ticket;

class ScrapeCommand extends Command
{
    protected function configure()
    {
        $this->setName('scrape');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = 'https://www.tickx.co.uk/manchester/gigs/';

        $client = new Client();
        $htmlPage = $client->request('GET', $url);
        $eventUrls = $htmlPage->filter('div.paper-elevation-1')->each(function ($eventCard, $i) {
            return $eventCard->filter('a.btn-contained-primary')->extract(['href']);
        });

        $eventsFound = 0;
        foreach ($eventUrls as $eventUrl) {
            if (empty($eventUrl[0])) {
                continue;
            }

            $eventUrl = $eventUrl[0];
            $eventPage = $client->request('GET', $eventUrl);
            preg_match('/\d+/', $eventUrl, $remoteId);

            try {
                $event = $this->getEventFromPage($eventPage);
                $event->setRemoteId($remoteId[0]);
            } catch (\Throwable $t) {
                var_dump($t->getMessage());
                continue;
            }

            $eventsFound++;

            $tickets = $eventPage->filter('div.c-well div.ticket-wrapper')->each(function ($ticketCard, $i) {
                try {
                    return $this->getTicketFromCard($ticketCard);
                } catch (\Throwable $t) {
                    var_dump($t->getMessage());
                    return null;
                }
            });

            $event->setTickets(array_filter($tickets));

            $event->save();

            if ($eventsFound >= 20) {
                break;
            }
        }

        return 'Successful Run';
    }

    private function getEventFromPage($eventPage)
    {
        return $event = (new Event())
            ->setTitle($eventPage->filter('h1.hero-title')->extract(['_text'])[0])
            ->setDescription($eventPage->filter('div.o-layout__item p.typ-body1.typ-linebreaks')->extract(['_text'])[0])
            ->setImage($eventPage->filter('div.hero-content-image img')->extract(['src'])[0])
            ->setDate($eventPage->filter('div.hero-event-date h2')->extract(['_text'])[0])
            ->setTime($eventPage->filter('div.hero-event-date p')->extract(['_text'])[0])
            ->setVenueName($eventPage->filter('div.hero-content-item div.bd a.hero-title')->extract(['_text'])[0]);
    }

    private function getTicketFromCard($ticketCard)
    {
        $ticketLink = $ticketCard->filter('div.ticket-cta a')->extract(['href'])[0];
        $ticketParts = explode('_', $ticketLink);
        $ticket = (new Ticket())
            ->setSeller(end($ticketParts))
            ->setPrice($ticketCard->filter('div.ticket-price span')->extract(['_text'])[1])
            ->setLink($ticketLink);
        if (empty($ticket->getPrice())) {
            return null;
        }

        return $ticket;
    }
}
