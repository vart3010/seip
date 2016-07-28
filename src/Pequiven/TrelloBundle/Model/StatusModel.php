<?php

namespace Pequiven\TrelloBundle\Model;

abstract class StatusModel
{
    const STATUS_PENDING = 0;
    
    const STATUS_TODO = 1;

    const STATUS_APPROVED = 2;

    const STATUS_ACCEPTED = 3;
}