<?php

    class IndexController extends BaseController {

        public function getIndex(){
            return View::make('index.index');
        }

    }