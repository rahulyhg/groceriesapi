<?php

if (! getenv('DATABASE_DSN')) {
    throw new Exception('missing environment variable DATABASE_DSN');
}

if (! getenv('DATABASE_USER')) {
    throw new Exception('missing environment variable DATABASE_USER');
}

if (! getenv('DATABASE_PASS')) {
    throw new Exception('missing environment variable DATABASE_PASS');
}

if (! getenv('JWT_ISSUER')) {
    throw new Exception('missing environment variable JWT_ISSUER');
}

if (! getenv('JWT_AUDIENCE')) {
    throw new Exception('missing environment variable JWT_AUDIENCE');
}

if (! getenv('JWT_KEY')) {
    throw new Exception('missing environment variable JWT_KEY');
}
