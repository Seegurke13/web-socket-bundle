<?php


namespace Seegurke13\WebSocketBundle\Service;


class ActionStore
{
    protected $actions = [];

    public function __construct(string $filename)
    {
        $this->actions = (include $filename);
    }

    public function getActions():array
    {
        return $this->actions;
    }
}