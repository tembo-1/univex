<?php

if (! function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Администратор');
    }
}

if (! function_exists('isManager')) {
    function isManager(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Менеджер');
    }
}
