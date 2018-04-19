<?php
//vvv

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::table('users')->insert(
				[
					'email' => 'admin@domain.com',
					'password' => Hash::make('admin'),
					'e' => 1,
					'role' => 'admin',
					'lang' => 'en',
					'name' => 'Admin',
				]
			);
		$home = DB::table('sections')->insertGetId(
				[
					'name' => 'Home',
					'h1' => 'Home',
					'url' => 'en',
					'e' => 1,
					'lang' => 'en',
					'mode' => '',
					'body' => '',
					'seq' => 0,
				]
			);
		$start = DB::table('sections')->insertGetId(
				[
					'parent_id' => $home,
					'name' => 'About',
					'h1' => 'About',
					'url' => '',
					'e' => 1,
					'lang' => 'en',
					'mode' => '',
					'body' => 'Hello',
					'seq' => 10,
				]
			);
		DB::table('sections')->where('id',$home)->update(['redirect_id'=>$start]);
		DB::table('sections')->insert(
				[
				[
					'parent_id' => $home,
					'name' => 'Contacts',
					'h1' => 'Contacts',
					'url' => 'contacts',
					'e' => 1,
					'lang' => 'ru',
					'mode' => '',
					'body' => 'Address, Phone...',
					'seq' => 20,
				],
				[
					'parent_id' => null,
					'name' => 'Sections',
					'h1' => 'Sections',
					'url' => 'admin/sections',
					'e' => 0,
					'lang' => 'en',
					'mode' => '',
					'body' => '',
					'seq' => 100,
				],
				[
					'parent_id' => null,
					'name' => 'Users',
					'h1' => 'Users',
					'url' => 'admin/users',
					'e' => 0,
					'lang' => 'en',
					'mode' => '',
					'body' => '',
					'seq' => 110,
				],
				]
			);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections')->whereIn('url',['','contacts','admin/sections','admin/users'])->delete();
        Schema::table('sections')->where('url','en')->delete();
        Schema::table('users')->where('email','admin@domain.com')->delete();
    }
}
