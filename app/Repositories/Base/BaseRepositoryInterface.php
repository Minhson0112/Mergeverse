<?php

namespace App\Repository\Base;

interface BaseRepositoryInterface
{
    public function getModel(): string;
    public function setModel(): void;
}
