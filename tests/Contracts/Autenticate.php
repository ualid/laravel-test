<?php
namespace Tests\Contracts;
trait Autenticate
{

    public function login($credentials)
    {
       return $this->post('api/login', $credentials);
    }
}
