<?php

namespace App\Entities;

use CodeIgniter\Entity;

use Spatie\Enum\Enum;

/**
 * @method static self LEARNER()
 * @method static self WRITER()
 * @method static self EDITOR()
 * @method static self ADMIN()
 */
class RoleCode extends Enum {
}

/**
 * @property int $id
 * @property RoleCode $code
 * @property bool $status
 */
class Role extends Entity {
}
