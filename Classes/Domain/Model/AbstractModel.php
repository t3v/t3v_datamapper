<?php
namespace T3v\T3vDataMapper\Domain\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * The abstract model class.
 *
 * @package T3v\T3vDataMapper\Domain\Model
 */
abstract class AbstractModel extends Model {
  const CREATED_AT = 'crdate';
  const UPDATED_AT = 'tstamp';

  /**
   * The primary key.
   *
   * Overwrites the default table identifier.
   *
   * @var string
   */
  protected $primaryKey = 'uid';

  /**
   * Overwrites the storage format of the model's date columns.
   *
   * @var string
   */
  protected $dateFormat = 'U';
}
