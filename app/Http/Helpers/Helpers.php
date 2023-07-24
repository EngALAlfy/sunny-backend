<?php

if (!function_exists('upload_image')) {
    function upload_image($image): string
    {
        $image_name = Time() . "-" . $image->getClientOriginalName();
        $dir_name = "photos";
        $image->storePubliclyAs($dir_name, $image_name, 'public');
        return $image_name;
    }
}
