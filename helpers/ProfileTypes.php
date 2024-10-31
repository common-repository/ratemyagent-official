<?php

namespace Rma\Helpers;


class ProfileTypes
{
    public static function get_profile_types($region = null): array
    {
        $types = [
            ['label' => __('Agent'), 'value' => 'agent'],
            ['label' =>  __('Agency'), 'value' =>  'agency'],
        ];
        
        if ($region === 'AU') {
            $types[] = ['label' => __('Mortgage Broker'), 'value' => 'mortgage-broker'];
        }

        return $types;
    }
}
