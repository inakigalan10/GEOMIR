<?php
 
namespace Tests\Feature;
 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
 
class DbTest extends TestCase
{
   public function test_admin()
   {
       $count = DB::table('users')
               ->where('username', '=', 'admin')
               ->count();
       $this->assertEquals($count, 1);
   }
}
