<?php

namespace TickX\Scraper\Model;

class Ticket
{

    protected $price;
    protected $seller;
    protected $link;

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getSeller()
    {
        return $this->seller;
    }

    public function setSeller($seller)
    {
        $this->seller = $seller;
        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

}