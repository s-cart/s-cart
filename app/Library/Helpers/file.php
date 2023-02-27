<?php
/**
 * File function process image
 */
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Function upload image
 */
if (!function_exists('sc_image_upload') && !in_array('sc_image_upload', config('helper_except', []))) {
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
            sc_report($e->getMessage());
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
            $url =  'storage/' . $pathFile;
        } else {
            $url =  Storage::disk($disk)->url($pathFile);
        }

        return  [
            'fileName' => $fileName,
            'pathFile' => $pathFile,
            'url' => $url,
        ];
    }
}
/**
 * Function upload file
 */
if (!function_exists('sc_file_upload') && !in_array('sc_file_upload', config('helper_except', []))) {
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
            $url =  'storage/' . $pathFile;
        } else {
            $url =  Storage::disk($disk)->url($pathFile);
        }
        return  [
            'fileName' => $fileName,
            'pathFile' => $pathFile,
            'url' => $url,
        ];
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
if (!function_exists('sc_remove_file') && !in_array('sc_remove_file', config('helper_except', []))) {
    function sc_remove_file($pathFile, $disk = null)
    {
        if ($disk) {
            return Storage::disk($disk)->delete($pathFile);
        } else {
            return Storage::delete($pathFile);
        }
    }
}

/**
 * Function insert watermark
 */
if (!function_exists('sc_image_insert_watermark') && !in_array('sc_image_insert_watermark', config('helper_except', []))) {
    function sc_image_insert_watermark($pathFile, $pathWatermark = null)
    {
        if (!$pathWatermark) {
            $pathWatermark = sc_config('upload_watermark_path');
        }
        if (empty($pathWatermark)) {
            return false;
        }
        $pathReal = config('filesystems.disks.public.root') . '/' . $pathFile;
        Image::make($pathReal)
            ->insert(public_path($pathWatermark), 'bottom-right', 10, 10)
            ->save($pathReal);
        return true;
    }
}
/**
 * Function generate thumb
 */
if (!function_exists('sc_image_generate_thumb') && !in_array('sc_image_generate_thumb', config('helper_except', []))) {
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
}
/**
 * Function rener image
 */
if (!function_exists('sc_image_render') && !in_array('sc_image_render', config('helper_except', []))) {
    function sc_image_render($path, $width = null, $height = null, $alt = null, $title = null, $urlDefault = null, $options = '')
    {
        $image = sc_image_get_path($path, $urlDefault);
        $style = '';
        $style .= ($width) ? ' width:' . $width . ';' : '';
        $style .= ($height) ? ' height:' . $height . ';' : '';
        return '<img  alt="' . $alt . '" title="' . $title . '" ' . (($options) ?? '') . ' src="' . sc_file($image) . '"   ' . ($style ? 'style="' . $style . '"' : '') . '   >';
    }
}
/*
Return path image
 */
if (!function_exists('sc_image_get_path') && !in_array('sc_image_get_path', config('helper_except', []))) {
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
}
/*
Function get path thumb of image if saved in storage
 */
if (!function_exists('sc_image_get_path_thumb') && !in_array('sc_image_get_path_thumb', config('helper_except', []))) {
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
            return sc_image_get_path($pathFile);
        }
    }
}



if (!function_exists('sc_zip') && !in_array('sc_zip', config('helper_except', []))) {
    /*
    Zip file or folder
     */
    function sc_zip(string $pathToSource, string $pathSaveTo)
    {
        if (extension_loaded('zip')) {
            if (file_exists($pathToSource)) {
                $zip = new \ZipArchive();
                if ($zip->open($pathSaveTo, \ZIPARCHIVE::CREATE)) {
                    $pathToSource = str_replace('\\', '/', realpath($pathToSource));
                    if (is_dir($pathToSource)) {
                        $iterator = new \RecursiveDirectoryIterator($pathToSource);
                        // skip dot files while iterating
                        $iterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = str_replace('\\', '/', realpath($file));
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($pathToSource . '/', '', $file . '/'));
                            } elseif (is_file($file)) {
                                $zip->addFromString(str_replace($pathToSource . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } elseif (is_file($pathToSource)) {
                        $zip->addFromString(basename($pathToSource), file_get_contents($pathToSource));
                    }
                }
                return $zip->close();
            }
        }
        return false;
    }
}


if (!function_exists('sc_unzip') && !in_array('sc_unzip', config('helper_except', []))) {
    /**
     * Unzip file to folder
     *
     * @return  [type]  [return description]
     */
    function sc_unzip(string $pathToSource, string $pathSaveTo)
    {
        $zip = new \ZipArchive();
        if ($zip->open(str_replace("//", "/", $pathToSource)) === true) {
            $zip->extractTo($pathSaveTo);
            return $zip->close();
        }
        return false;
    }
}


/**
 * Process path file
 */
if (!function_exists('sc_file') && !in_array('sc_file', config('helper_except', []))) {
    function sc_file(string $pathFile = null, bool $security = null):string
    {
        return asset($pathFile, $security);
    }
}

if (!function_exists('sc_path_download_render') && !in_array('sc_path_download_render', config('helper_except', []))) {
    /*
    Render path download
     */
    function sc_path_download_render(string $string):string
    {
        if (filter_var($string, FILTER_VALIDATE_URL)) {
            return $string;
        } else {
            return \Storage::disk('path_download')->url($string);
        }
    }
}

if (!function_exists('sc_convertPHPSizeToBytes') && !in_array('sc_convertPHPSizeToBytes', config('helper_except', []))) {
    /**
    * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
    * 
    * @param string $sSize
    * @return integer The value in bytes
    */
    function sc_convertPHPSizeToBytes(string $sSize):int
    {
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix,array('P','T','G','M','K'))){
            return (int)$sSize;  
        } 
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
                // Fallthrough intended
            case 'T':
                $iValue *= 1024;
                // Fallthrough intended
            case 'G':
                $iValue *= 1024;
                // Fallthrough intended
            case 'M':
                $iValue *= 1024;
                // Fallthrough intended
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int)$iValue;
    }
}

if (!function_exists('sc_getMaximumFileUploadSize') && !in_array('sc_getMaximumFileUploadSize', config('helper_except', []))) {
    /**
    * This function returns the maximum files size that can be uploaded 
    * in PHP
    * @returns  File size in bytes
    **/
    function sc_getMaximumFileUploadSize($unit = null)
    {
        $valueUnit = 1;
        switch ($unit) {
            case 'P':
                $valueUnit = 1024 * 1024 * 1024 * 1024 * 1024;
                break;
            case 'T':
                $valueUnit = 1024 * 1024 * 1024 * 1024;
                break;
            case 'G':
                $valueUnit = 1024 * 1024 * 1024;
                break;
            case 'M':
                $valueUnit = 1024 * 1024;
                break;
            case 'K':
                $valueUnit = 1024;
                break;
            default:
                $valueUnit = 1;
                break;
        }
        return min(sc_convertPHPSizeToBytes(ini_get('post_max_size')), sc_convertPHPSizeToBytes(ini_get('upload_max_filesize')))/ $valueUnit;
    }
}