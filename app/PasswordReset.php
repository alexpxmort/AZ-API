<?php

namespace App;


class PasswordReset extends BaseModel
{
    protected $fillable = [
        'email', 'token'
    ];
}
