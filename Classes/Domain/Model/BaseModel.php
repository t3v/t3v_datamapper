<?php
declare(strict_types=1);

namespace T3v\T3vDataMapper\Domain\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * The base model class.
 *
 * @package T3v\T3vDataMapper\Domain\Model
 */
class BaseModel extends Model
{
    /**
     * The table identifier for `created_at` and `updated_at`.
     */
    public const CREATED_AT = 'crdate';
    public const UPDATED_AT = 'tstamp';

    /**
     * The primary key.
     *
     * Overwrites the default table identifier.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * The date format.
     *
     * Overwrites the default storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';
}
