<?php
namespace App\Enums;

enum StatusEnum: String {
    case NotPaid = 'Not Paid';
    case Paid = 'Paid';
    case Cancelled = 'Cancelled';
}
