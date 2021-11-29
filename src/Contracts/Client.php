<?php

namespace Vdhicts\HiHaHo\Contracts;

interface Client
{
    public function perform(Request $request): Response;
}