<?php

  if(!function_exists('dd')){
      function dd($value) {
          var_dump($value);die();
      }
  }

  function mydd($value){
  	dd($value);
  }