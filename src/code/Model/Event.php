<?php

namespace TickX\Scraper\Model;

class Event
{

    protected $uuid;
    protected $title;
    protected $date;
    protected $time;
    protected $image;
    protected $description;
    protected $tickets;
    protected $venueName;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getTickets()
    {
        return $this->tickets;
    }

    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
        return $this;
    }

    public function getVenueName()
    {
        return $this->venueName;
    }

    public function setVenueName($venueName)
    {
        $this->venueName = $venueName;
        return $this;
    }

}