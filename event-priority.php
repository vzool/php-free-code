<?php
class Event
{
    private $name;
    private $params;

    public function __construct($name, $params = array()) {
        $this->name = $name;
        $this->params = $params;
    }

    public function getName() {
        return $this->name;
    }

    public function getParams() {
        return $this->params;
    }
}

class EventManager
{
    private $events;

    public function __construct() {
        $this->events = new SplPriorityQueue;
    }

    public function attach($name, $callback, $priority = 0) {
        $this->events->insert(array($name, $callback), $priority);
    }

    public function trigger($name, $params = array(), $callback = null) {
        foreach ($this->events as $event) {
            if ($event[0] = $name) {
                $e = new Event($name, $params);
                if ($r = $event[1]($e)) {
                    if (is_callable($callback)) {
                        $callback($r);
                    }
                }
            }
        }
    }
}

$events = new EventManager;

$events->attach('do', function($e) {
    echo "Registered first\n";
    return "Hello SALAM";
}, 102);

$events->attach('do', function($e) {
    echo "Registered second\n";
    return time();
}, 101);

$return = $events->trigger('do', array('a', 'b', 'c'), function($r) {
    echo "<h1>$r</h1>\n";
});

echo "<h1>$return</h1>";