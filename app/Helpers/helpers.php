<?php

if (! function_exists('statusColor')) {
    function statusColor($status) {
        return match($status) {
            'open' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}