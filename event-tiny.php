<?php
class Event
{
    public static $events = array();

    public static function trigger($event, $args = array(), $callback = null)
    {
        if(isset(self::$events[$event]))
        {
            foreach(self::$events[$event] as $func)
            {
                $r = call_user_func($func, $args);
                
                if(is_callable($callback))
                {
                    $callback($r);
                }
            }
        }
    }

    public static function bind($event, Closure $func)
    {
        self::$events[$event][] = $func;
    }
}

/*########################### Playground ################################*/

Event::bind('hello', function($args){

    echo "Hello World!";
    echo "<pre>";
    print_r($args);
    echo "</pre>";

    return 'Salam';
});

Event::bind(sha1(time()), function($args){
    echo "Hashed Function";
});

Event::bind(0, function(){
    echo "Zero";
});

Event::trigger('hello', array(258, 741));

Event::trigger('hello', array(654, 147), function($r){

    echo "<h1>Returned: $r</h1>";
});


Event::trigger(0);

echo "<pre>";
print_r(Event::$events);
echo "</pre>";