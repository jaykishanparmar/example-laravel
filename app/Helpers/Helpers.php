<?php 

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

if (!function_exists('addFiles')) {

    function addFiles($request, $data)
    {
        $image = $request->file('attachment');
        $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images', $imageName, 'public');
        $imageURL = Storage::url($imagePath);
        $data['image_data'] = [
            'image_path' => $imagePath,
            'image_url' => $imageURL
        ];
        
        return $data;
    }
 }