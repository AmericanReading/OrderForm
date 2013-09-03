<?php

namespace AmericanReading\OrderForm;

/**
 * Abstract base class for creating an orderform from an object (e.g., an
 * object decode from JSON).
 *
 * You must subclass OrderForm to provide methods for creating markup.
 */
abstract class OrderForm
{
    protected $data;
    protected $indexedArrays;

    /**
     * Create a new order form using an associative array of data that describes
     * the forms structure.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->indexedArrays = array();
    }

    /**
     * Return the data array.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return an array of references to order form items indexed by $indexField
     *
     * @param string $indexField
     * @return mixed
     */
    public function &getIndexedArray($indexField)
    {
        if (!isset($this->indexedArrays[$indexField])) {
            $arr = array();
            $this->addToIndexedArray($indexField, $this->data, $arr);
            $this->indexedArrays[$indexField] = & $arr;
        }

        return $this->indexedArrays[$indexField];
    }

    /**
     * Add references to the indexed array. This method is used by
     * getIndexedArray()
     *
     * @param string $indexField
     * @param array $item
     * @param array $index
     */
    protected function addToIndexedArray($indexField, &$item, &$index)
    {
        if (isset($item[$indexField])) {
            $index[$item[$indexField]] = & $item;
        }

        if (isset($item['items'])
            && is_array($item['items'])
            && count($item['items']) > 0
        ) {
            foreach ($item['items'] as &$child) {
                $this->addToIndexedArray($indexField, $child, $index);
            }
        }
    }
}
