<?php

namespace Migrations;

use Illuminate\Database\Schema\Blueprint;
use ZnLib\Migration\Domain\Base\BaseColumnMigration;
use ZnLib\Migration\Domain\Base\BaseCreateTableMigration;
use ZnLib\Migration\Domain\Enums\ForeignActionEnum;

class m_2020_08_31_115061_eav_entity_attribute_add_fileds extends BaseColumnMigration
{

    protected $tableName = 'eav_entity_attribute';

    public function tableSchema()
    {
        return function (Blueprint $table) {
            $table->boolean('is_list')->default(false)->comment('Является ли списком значений?');
        };
    }
}