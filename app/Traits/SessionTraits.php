<?php

namespace App\Traits;

trait SessionTraits
{
    public function ClearSession()
    {
        if (session()->has('gamekind') && session()->has('lang')) {
            session()->forget(['gamekind', 'lang']);
        }
    }

}
