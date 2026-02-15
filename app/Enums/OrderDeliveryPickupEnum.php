<?php

namespace App\Enums;

enum OrderDeliveryPickupEnum: string
{
    case DELIVERY = 'delivery';
    case PICKUP = 'pickup';
}
