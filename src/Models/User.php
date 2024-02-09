<?php
/**
 * BellHop
 *
 * @author    Jacques Marneweck <jacques@siberia.co.za>
 * @copyright 2018 Jacques Marneweck.  All rights strictly reserved.
 */

namespace Jacques\BellHop\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \Illuminate\Database\Eloquent\Model
{
    use SoftDeletes;
}
