<?php
namespace T3v\T3vDataMapper\Domain\Model;

use \Illuminate\Database\Eloquent\Model;

/**
 * Abstract Model Class
 *
 * @package T3v\T3vDataMapper\Domain\Model
 */
abstract class AbstractModel extends Model {
  const CREATED_AT = 'crdate';
  const UPDATED_AT = 'tstamp';

  /**
   * Overwrites the default table identifier.
   *
   * @var string
   */
  protected $primaryKey = 'uid';
}