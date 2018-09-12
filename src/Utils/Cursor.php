<?php

namespace Paylike\Utils;


use Paylike\Paylike;

/**
 * Class Cursor
 *
 * @package Paylike\Utils
 */
class Cursor implements \Iterator, \Countable, \ArrayAccess
{

    /**
     * Endpoint called to fetch more data
     * @var string
     */
    private $endpoint;

    private $current_index = 0;

    private $total_count = 0;

    private $collection = array();

    private $params = array();

    /**
     * @var Paylike
     */
    private $paylike;

    /**
     * Cursor constructor.
     * @param $endpoint
     * @param array $params
     * @param array $data
     * @param Paylike $paylike
     * @throws \Exception
     */
    public function __construct($endpoint, array $params, array $data, Paylike $paylike)
    {
        $this->endpoint = $endpoint;
        $this->collection = $data;
        $this->paylike = $paylike;
        $this->total_count = count($this->collection);
        $this->params = $this->setParams($params);
    }


    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->current_index = 0;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->collection[$this->current_index];
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->current_index;
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return null any returned value is ignored.
     */
    public function next()
    {
        ++$this->current_index;
        if (!$this->valid() && $this->couldHaveMoreItems()) {
            $this->fetchNext();
        }
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->collection[$this->current_index]);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return max($this->total_count, count($this->collection));
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        $exists = isset($this->collection[$offset]);
        if ($exists) {
            return $exists;
        }
        if ($this->couldHaveMoreItems()) {
            $this->fetchNext();
            return $this->offsetExists($offset);
        } else {
            return $exists;
        }
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        $value = isset($this->collection[$offset]) ? $this->collection[$offset] : null;
        if ($value) {
            return $value;
        }
        if ($this->couldHaveMoreItems()) {
            $this->fetchNext();
            return $this->offsetGet($offset);
        } else {
            return $value;
        }
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * @return $this
     */
    private function fetchNext()
    {
        $this->updateOffset()->fetch();
        return $this;

    }

    /**
     * @return $this
     */
    private function fetch()
    {
        $api_response = $this->paylike->client->request('GET', $this->endpoint, $this->params);
        $data = $api_response->json;
        if (count($data)) {
            $this->collection = array_merge($this->collection, $data);
            $this->total_count += count($data);
        }
        return $this;
    }

    /**
     * If after is set, then we increment it, otherwise we increment before
     */
    private function updateOffset()
    {
        if ($this->after()) {
            $this->params['after'] = $this->collection[$this->total_count - 1]['id'];
        } else {
            $this->params['before'] = $this->collection[$this->total_count - 1]['id'];
        }
        return $this;
    }

    /**
     * @return mixed
     */
    private function after()
    {
        return $this->params['after'];
    }

    /**
     * @return mixed
     */
    private function before()
    {
        return $this->params['before'];
    }

    /**
     * @return mixed
     */
    private function limit()
    {
        return $this->params['limit'];
    }

    /**
     * @param $params
     * @return array
     * @throws \Exception
     */
    private function setParams($params)
    {
        $return = array(
            'after' => null,
            'before' => null,
            'limit' => 10,
            'filter' => array()
        );

        if (isset($params['limit'])) {
            $limit = $params['limit'];
            if (!is_numeric($limit) || $limit <= 0) {
                throw new \Exception('Limit is not valid. It has to be a numerical value (> 0)');
            }
            $return['limit'] = $limit;
        }

        if (isset($params['after'])) {
            $after = $params['after'];
            if (!is_string($after)) {
                throw new \Exception('After is not valid. It has to be a string');
            }
            $return['after'] = $after;
        }

        if (isset($params['before'])) {
            $before = $params['before'];
            if (!is_string($before)) {
                throw new \Exception('Before is not valid. It has to be a string');
            }
            $return['before'] = $before;
        }

        if (isset($params['filter'])) {
            $filter = $params['filter'];
            if (!is_array($filter)) {
                throw new \Exception('Filter is not valid. It has to be an array');
            }
            if (isset($filter['merchantId'])) {
                if (!is_string($filter['merchantId'])) {
                    throw new \Exception('Merchant filter is not valid. It has to be an string');
                }
                $return['filter']['merchantId'] = $filter['merchantId'];
            }
            if (isset($filter['transactionId'])) {
                if (!is_string($filter['transactionId'])) {
                    throw new \Exception('Transaction filter is not valid. It has to be an string');
                }
                $return['filter']['transactionId'] = $filter['transactionId'];
            }
        }
        return $return;
    }

    private function couldHaveMoreItems()
    {
        return ($this->count() % $this->limit() == 0);
    }

}
