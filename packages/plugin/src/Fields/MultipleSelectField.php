<?php
/**
 * Freeform for Craft CMS.
 *
 * @author        Solspace, Inc.
 * @copyright     Copyright (c) 2008-2022, Solspace, Inc.
 *
 * @see           https://docs.solspace.com/craft/freeform
 *
 * @license       https://docs.solspace.com/license-agreement
 */

namespace Solspace\Freeform\Fields;

use Solspace\Freeform\Attributes\Field\Type;
use Solspace\Freeform\Library\Composer\Components\Fields\AbstractExternalOptionsField;
use Solspace\Freeform\Library\Composer\Components\Fields\Interfaces\MultipleValueInterface;
use Solspace\Freeform\Library\Composer\Components\Fields\Traits\MultipleValueTrait;

#[Type(
    name: 'Multi-Select',
    typeShorthand: 'multiple-select',
    iconPath: __DIR__.'/Icons/text.svg',
)]
class MultipleSelectField extends AbstractExternalOptionsField implements MultipleValueInterface
{
    use MultipleValueTrait;

    public function getType(): string
    {
        return self::TYPE_MULTIPLE_SELECT;
    }

    public function getInputHtml(): string
    {
        $attributes = $this->getCustomAttributes();
        $this->addInputAttribute('class', $attributes->getClass());

        $output = '<select '
            .$this->getInputAttributesString()
            .$this->getAttributeString('name', $this->getHandle().'[]')
            .$this->getAttributeString('id', $this->getIdAttribute())
            .$this->getParameterString('multiple', true)
            .$attributes->getInputAttributesAsString()
            .$this->getRequiredAttribute()
            .'>';

        foreach ($this->getOptions() as $option) {
            $output .= '<option value="'.$option->getValue().'"'.($option->isChecked() ? ' selected' : '').'>';
            $output .= $this->translate($option->getLabel());
            $output .= '</option>';
        }

        $output .= '</select>';

        return $output;
    }

    public function getValueAsString(bool $optionsAsValues = true): string
    {
        if (!$optionsAsValues) {
            return implode(', ', $this->getValue());
        }

        $labels = [];
        foreach ($this->getOptions() as $option) {
            if ($option->isChecked()) {
                $labels[] = $option->getLabel();
            }
        }

        return implode(', ', $labels);
    }
}
