<?php

namespace Advicepharma\Tablegenerator\Elements;

use Advicepharma\Tablegenerator\Contracts\CustomColumnContract;

class BadgeColumn extends Column implements CustomColumnContract
{
    public function __construct()
    {
        parent::__construct();

        $this->type = 'badge';

        $this->properties = [
            'color' => '#ffffff',
            'background' => '#2E7D32',
            'size' => 'small',
            'field' => '',
        ];
    }

    public function color(string $color)
    {
        $this->properties['color'] = $color;

        return $this;
    }

    public function background(string $background)
    {
        $this->properties['background'] = $background;

        return $this;
    }

    public function size(string $size)
    {
        $this->properties['size'] = $size;

        return $this;
    }

    public function field($field = null): static|string
    {
        if ($field !== null) {
            $this->properties['field'] = $field;
        }

        return parent::field($field);
    }

    public function addProperty($property, $value)
    {
        $this->properties[$property] = $value;

        return $this;
    }
}
