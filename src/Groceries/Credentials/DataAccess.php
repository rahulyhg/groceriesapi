<?php

namespace Groceries\Credentials;

interface DataAccess
{
    public function getCredentialsByUsername(string $username) : array;
}
