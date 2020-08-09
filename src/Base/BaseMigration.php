<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Closure;
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use voku\helper\ASCII;

abstract class BaseMigration extends Migration
{
    protected $table_name = '';

    /**
     * 设置自增长开始值
     * @param int $increment
     */
    protected function setAutoIncrement(int $increment = null)
    {
        if (!$increment) {
            $increment = 100000;
        }

        Schema::getConnection()->statement(
            "ALTER TABLE {$this->table_name} AUTO_INCREMENT={$increment}");
    }

    public function up() : void
    {
        $createTable = [$this, 'create'];
        Schema::create($this->table_name, Closure::fromCallable($createTable));

        $this->created();
    }

    public function create(Blueprint $table)
    {
        
    }

    public function created()
    {

    } 

    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
    }
}
