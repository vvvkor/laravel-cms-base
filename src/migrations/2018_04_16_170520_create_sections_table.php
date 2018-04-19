<?php
//vvv

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
				$table->integer('parent_id')->unsigned()->nullable();
				$table->string('name',255)->default('');
				$table->string('h1',255)->default('');
				$table->string('url',100)->default('')->unique();
				$table->tinyInteger('e')->default(0);
				$table->mediumText('body');
				$table->integer('redirect_id')->unsigned()->nullable();
				$table->string('mode',1)->default('');
				$table->string('lang',2)->default('');
				$table->integer('seq')->default(0);
				$table->string('fuid',255)->default('');
				$table->string('fnm',255)->default('');
				$table->integer('owner_id')->unsigned()->nullable();
				$table->timestamp('pub_dt')->nullable();
				$table->timestamps();
        });
        Schema::table('sections', function (Blueprint $table) {
				$table->foreign('parent_id')->references('id')->on('sections');
				$table->foreign('redirect_id')->references('id')->on('sections');
				$table->foreign('owner_id')->references('id')->on('users');
		});
        Schema::table('users', function (Blueprint $table) {
				$table->tinyInteger('e')->default(0);
				$table->string('lang',2)->default('');
				$table->string('role',1)->default('');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('e');
		});
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('lang');
		});
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('role');
		});
        Schema::dropIfExists('sections');
    }
}
