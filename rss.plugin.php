<?php

class Rss extends \Ghastly\Plugin\Plugin {
    public $events;

    public function __construct()
    {
        $this->events = [
            ['event'=>'Ghastly.PreRoute', 'func'=>'onPreRoute']
        ];
    }

    public function onPreRoute(\Ghastly\Event\PreRouteEvent $event)
    {
        $event->renderer->setTemplateVar('rss_url', 'feed');
       
        $event->router->respond('/feed', function() use ($event){
            $posts = $event->postModel->findAll(10);

            $event->renderer->setTemplateVar('posts', $posts);         
            $event->renderer->addTemplateDir('plugins/rss');
            $event->renderer->setTemplate('rss.xml'); 

            header('Content-Type: application/rss+xml; charset=ISO-8859-1');   
        });
    }
}