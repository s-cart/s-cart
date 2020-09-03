<?php
/**
 * File function process image
 * @author Lanh Le <lanhktc@gmail.com>
 * From version: S-cart 3.0
 */
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Function upload image
 */
function sc_image_upload($fileContent, $disk = 'public', $path = null, $name = null, $options = ['unique_name' => true, 'thumb' => false, 'watermark' => false])
{
    $pathFile = null;
    try {
        $fileName = false;
        if ($name) {
            $fileName = $name . '.' . $fileContent->getClientOriginalExtension();
        } elseif (empty($options['unique_name'])) {
            $fileName = $fileContent->getClientOriginalName();
        }

        //Save as file
        if ($fileName) {
            $pathFile = Storage::disk($disk)->putFileAs(($path ?? ''), $fileContent, $fileName);
        }
        //Save file id unique
        else {
            $pathFile = Storage::disk($disk)->putFile(($path ?? ''), $fileContent);
        }
    } catch (\Throwable $e) {
        return null;
    }

    if ($pathFile && $disk == 'public') {
        //generate thumb
        if (!empty($options['thumb']) && sc_config('upload_image_thumb_status')) {
            sc_image_generate_thumb($pathFile, $widthThumb = 250, $heightThumb = null, $disk);
        }

        //insert watermark
        if (!empty($options['watermark']) && sc_config('upload_watermark_status')) {
            sc_image_insert_watermark($pathFile);
        }
    }
    if ($disk == 'public') {
        return 'storage/' . $pathFile;
    } else {
        return Storage::disk($disk)->url($pathFile);
    }
}

/**
 * Function upload file
 */
function sc_file_upload($fileContent, $disk = 'public', $path = null, $name = null)
{
    $pathFile = null;
    try {
        $fileName = false;
        if ($name) {
            $fileName = $name . '.' . $fileContent->getClientOriginalExtension();
        } else {
            $fileName = $fileContent->getClientOriginalName();
        }

        //Save as file
        if ($fileName) {
            $pathFile = Storage::disk($disk)->putFileAs(($path ?? ''), $fileContent, $fileName);
        }
        //Save file id unique
        else {
            $pathFile = Storage::disk($disk)->putFile(($path ?? ''), $fileContent);
        }
    } catch (\Throwable $e) {
        return null;
    }
    if ($disk == 'public') {
        return 'storage/' . $pathFile;
    } else {
        return Storage::disk($disk)->url($pathFile);
    }
}

/**
 * Remove file
 *
 * @param   [string]  $disk  
 * @param   [string]  $path  
 * @param   [string]  $prefix  will remove
 *
 */
function sc_remove_file($pathFile, $disk = null) {
    if ($disk) {
        return Storage::disk($disk)->delete($pathFile);
    } else {
        return Storage::delete($pathFile);
    }
}

/**
 * Function insert watermark
 */
function sc_image_insert_watermark($pathFile)
{
    $pathWatermark = sc_config('upload_watermark_path');
    if (empty($pathWatermark)) {
        return false;
    }
    $pathReal = config('filesystems.disks.public.root') . '/' . $pathFile;
    Image::make($pathReal)
        ->insert(public_path($pathWatermark), 'bottom-right', 10, 10)
        ->save($pathReal);
}

/**
 * Function generate thumb
 */
function sc_image_generate_thumb($pathFile, $widthThumb = null, $heightThumb = null, $disk = 'public')
{
    $widthThumb = $widthThumb ?? sc_config('upload_image_thumb_width');
    if (!Storage::disk($disk)->has('tmp')) {
        Storage::disk($disk)->makeDirectory('tmp');
    }

    $pathReal = config('filesystems.disks.public.root') . '/' . $pathFile;
    $image_thumb = Image::make($pathReal);
    $image_thumb->resize($widthThumb, $heightThumb, function ($constraint) {
        $constraint->aspectRatio();
    });
    $tmp = '/tmp/' . time() . rand(10, 100);

    $image_thumb->save(config('filesystems.disks.public.root') . $tmp);
    if (Storage::disk($disk)->exists('/thumb/' . $pathFile)) {
        Storage::disk($disk)->delete('/thumb/' . $pathFile);
    }
    Storage::disk($disk)->move($tmp, '/thumb/' . $pathFile);
}

/**
 * Function rener image
 */

function sc_image_render($path, $width = null, $height = null, $alt = null, $title = null, $url = null, $options = '')
{
    $image = sc_image_get_path($path, $url);
    $style = '';
    $style .= ($width) ? ' width:' . $width . ';' : '';
    $style .= ($height) ? ' height:' . $height . ';' : '';
    return '<img  alt="' . $alt . '" title="' . $title . '" ' . (($options) ?? '') . ' src="' . asset($image) . '"   ' . ($style ? 'style="' . $style . '"' : '') . '   >';
}

/*
Return path image
 */
function sc_image_get_path($path, $urlDefault = null)
{
    $image = $urlDefault ?? 'images/no-image.jpg';
    if ($path) {
        if (file_exists(public_path($path)) || filter_var(str_replace(' ', '%20', $path), FILTER_VALIDATE_URL)) {
            $image = $path;
        } else {
            $image = $image;
        }
    }
    return $image;
}

/*
Function get path thumb of image if saved in storage
 */
function sc_image_get_path_thumb($pathFile)
{
    if (strpos($pathFile, "/storage/") === 0) {
        $arrPath = explode('/', $pathFile);
        $fileName = end($arrPath);
        $pathThumb = substr($pathFile, 0, -strlen($fileName)) . 'thumbs/' . $fileName;
        if (file_exists(public_path($pathThumb))) {
            return $pathThumb;
        } else {
            return sc_image_get_path($pathFile);
        }
    } else {
        return $pathFile;
    }
}
