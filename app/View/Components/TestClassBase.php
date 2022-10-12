<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TestClassBase extends Component
{
  //まずは値を指定する
    public $classBaseMessage;
    public $defaultMessage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classBaseMessage, $defaultMessage='初期値です')
    {
        $this->classBaseMessage = $classBaseMessage;//クラス別での初期値、属性の引き渡しはこのようにして行う必要がある
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tests.test-class-base-component');
    }
}
