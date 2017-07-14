<?php
namespace T3v\T3vDataMapper\Service\Validation;

use Illuminate\Validation\Factory;

use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

use T3v\T3vCore\Service\AbstractService;

/**
 * Validator Service Class
 *
 * @package T3v\T3vDataMapper\Service\Validation
 */
class ValidatorService extends AbstractService {
  /**
   * Get the validator factory.
   *
   * @param string $locale The optional locale, defaults to `en_US`
   * @return Illuminate\Validation\Factory The validator factory
   */
  public static function getValidator($locale = 'en_US') {
    $locale           = (string) $locale;
    $translator       = new Translator($locale, new MessageSelector());
    $validatorFactory = new Factory($translator);

    return $validatorFactory;
  }
}