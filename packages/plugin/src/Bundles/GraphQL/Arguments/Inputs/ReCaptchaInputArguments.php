<?php

namespace Solspace\Freeform\Bundles\GraphQL\Arguments\Inputs;

use craft\gql\base\Arguments;
use Solspace\Freeform\Bundles\GraphQL\Types\Inputs\ReCaptchaInputType;
use Solspace\Freeform\Form\Form;
use Solspace\Freeform\Library\Helpers\ReCaptchaHelper;

class ReCaptchaInputArguments extends Arguments
{
    private static Form $form;

    public static function setForm(Form $form): void
    {
        self::$form = $form;
    }

    public static function getArguments(): array
    {
        $reCaptchaEnabled = ReCaptchaHelper::canApplyReCaptcha(self::$form);

        if ($reCaptchaEnabled) {
            return [
                'reCaptcha' => [
                    'name' => 'reCaptcha',
                    'type' => ReCaptchaInputType::getType(),
                    'description' => 'The Recaptcha name/value.',
                ],
            ];
        }

        return [];
    }
}
