<?php

    namespace App\Controller\api;

    function check_Array(array $data, array $requiredKeys): array
    {
        $missingKeys = [];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                $missingKeys[] = $key;
            }
        }
        return $missingKeys;
    }