<?php
namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function render()
    {
        $error = $this->getMessage();
        return redirect('/')->with('Fail', $error);
    }

}
