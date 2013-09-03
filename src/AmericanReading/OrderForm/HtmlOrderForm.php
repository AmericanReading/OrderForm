<?php

namespace AmericanReading\OrderForm;

abstract class HtmlOrderForm extends OrderForm
{
     /**
     * Return the markup for the entire form.
     *
     * @return string
     */
    public function html()
    {
        $html = '';
        $html .= $this->htmlItem($this->data);
        return $html;
    }

    /**
     * Return the markup for one specific item of the form.
     *
     * @param $item
     * @return mixed
     */
    abstract protected function htmlItem($item);

    /**
     * Return the markup for the passed item's child items.
     * This method should be called from within htmlFormItem where the sublcass
     * should include the markup for nested items.
     *
     * @param array $parent
     * @return string
     */
    protected function htmlChildItems($parent)
    {
        $html = '';
        if (is_array($parent['items']) && count($parent['items']) > 0) {
            foreach ($parent['items'] as $child) {
                $html .= $this->htmlItem($child);
            }
        }
        return $html;
    }
}
