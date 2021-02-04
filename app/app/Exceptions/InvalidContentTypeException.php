<?php

namespace App\Exceptions;

use Exception;

class InvalidContentTypeException extends Exception
{
   public function render()
   {
      return response()->json(null, 415);
   }
}
