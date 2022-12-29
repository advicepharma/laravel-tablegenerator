<?php

namespace Advicepharma\Tablegenerator\Elements;

class Action
{
    const ACTION_EDIT = 'edit';

    const ACTION_LINK = 'link';

    const ACTION_DELETE = 'delete';

    const ACTION_RESTORE = 'restore';

    const ACTION_CUSTOM = 'custom';

    /**
     * Type of action
     *
     * @var string
     */
    public $type;

    /**
     * List of custom properties
     *
     * @var array
     */
    public array $properties;

    public function __construct()
    {
    }

    /**
     * Set the action type
     *
     * @param  string  $type
     * @param  string|null  $custom
     * @return static
     */
    public function type(string $type, string $custom = null): static
    {
        if ($type === self::ACTION_CUSTOM) {
            $this->type = $custom;
        } else {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Set properties
     *
     * @param  array  $properties
     * @return static
     */
    public function properties(array $properties): static
    {
        $this->properties = $properties;

        return $this;
    }
}
