<?php

namespace Knp\FriendlyContexts\Record\Collection;

use Knp\FriendlyContexts\Record\Collection;
use Knp\FriendlyContexts\Dictionary\Containable;

class Bag
{
    use Containable;

    protected $reflector;
    protected $collections = [];

    public function __construct(ObjectReflector $reflector)
    {
        $this->reflector = $reflector;
    }

    public function getCollection($entity)
    {
        foreach ($this->collections as $collection) {
            if ($collection->support($entity)) {
                return $collection;
            }
        }

        $new = new Collection($this->reflector);
        $new->support($entity);

        return $this->collections[] = $new;;
    }

    public function count()
    {
        return count($this->collections);
    }
}
