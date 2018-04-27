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
				[
					'email' => 'admin@domain.com',
					'password' => Hash::make('admin'),
					'e' => 1,
					'role' => 'a',
					'lang' => 'en',
					'name' => 'Admin',
				],
				[
					'email' => 'reader@domain.com',
					'password' => Hash::make('reader'),
					'e' => 1,
					'role' => 'r',
					'lang' => 'en',
					'name' => 'Reader',
				],
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
					'body' => '<ol>
<li>Using browser go to home page of your project.
<li>Log in as admin with e-mail <kbd>admin@domain.com</kbd> and password <kbd>admin</kbd>.
<li>Or log in as privileged reader with e-mail <kbd>reader@domain.com</kbd> and password <kbd>reader</kbd>.
<li>Go to home page again.
<li>For administrator, on top of page there are links to manage `Sections` and `Users`.
<li>For reader, there is a link to a protected page in top menu.
</ol>',
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
					'lang' => 'en',
					'mode' => '',
					'body' => 'Address, Phone...',
					'seq' => 20,
				],
				[
					'parent_id' => null,
					'name' => 'Services',
					'h1' => 'Services',
					'url' => 'services',
					'e' => 1,
					'lang' => 'en',
					'mode' => '',
					'body' => 'Info...',
					'seq' => 30,
				],
				[
					'parent_id' => null,
					'name' => 'Protected',
					'h1' => 'Protected',
					'url' => 'protected',
					'e' => 0,
					'lang' => 'en',
					'mode' => '',
					'body' => 'Private data...',
					'seq' => 40,
				],
				[
					'parent_id' => null,
					'name' => 'Главная',
					'h1' => 'Главная',
					'url' => 'ru',
					'e' => 1,
					'lang' => 'ru',
					'mode' => '',
					'body' => 'Привет',
					'seq' => 10,
				],
				/*
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
				*/
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
