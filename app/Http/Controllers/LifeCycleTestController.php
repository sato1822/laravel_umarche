<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    public function showServiceProviderTest()
    {
      $encrypt = app()->make('encrypter');
      $password = $encrypt->encrypt('password123');//暗号化している
      $sample = app()->make('serviceProviderTest');
      dd($sample, $password, $encrypt->decrypt($password));//元のパスワードに戻す
    }

    public function showServiceContainerTest()
    {
      app()->bind('lifeCycleTest', function(){
        return 'ライフサイクル';
      });

      $test = app()->make('lifeCycleTest');

      //サービスコンテナなし
      // $message = new Message();
      // $sample = new Sample($message);
      // $sample->run();

      //サービスコンテナあり
      app()->bind('sample', Sample::class);
      $sample = app()->make('sample');
      $sample->run();

      dd($test, app());
    }
}

class Sample
{
  public $message;
  public function __construct(Message $message)
  //DIという仕組みでインスタンス化しなくても使える仕組みになる
  //要するに最初に来るのはインスタンス化するクラス名であり二つ目にはそれを引数といて保管している状態になる
  {
    $this->message = $message;
  }
  public function run()
  {
    $this->message->send();
  }
}

class Message 
{
  public function send(){
    echo ('メッセージ表示');
  }
}
