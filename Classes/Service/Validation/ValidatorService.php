<?php
namespace T3v\T3vDataMapper\Service\Validation;

use Illuminate\Validation\Factory;

use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

use T3v\T3vCore\Service\AbstractService;

/**
 * The validator service class.
 *
 * @package T3v\T3vDataMapper\Service\Validation
 */
class ValidatorService extends AbstractService
{
    /**
     * Gets validator (factory).
     *
     * @param string $locale The optional locale, defaults to `en_US`
     * @return \Illuminate\Validation\Factory The validator factory
     */
    public static function getValidator(string $locale = 'en_US'): Factory
    {
        $translator = new Translator($locale, new MessageSelector());
        $validatorFactory = new Factory($translator);

        return $validatorFactory;
    }
}
