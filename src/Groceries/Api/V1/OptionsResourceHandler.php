<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionsResourceHandler
{
    public function options(Request $request)
    {
        return new Response(null, 204);
    }
}
