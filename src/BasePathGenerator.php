<?php

namespace Zareismail\Contracts;

use Spatie\MediaLibrary\PathGenerator\BasePathGenerator as PathGenerator; 
use Spatie\MediaLibrary\Models\Media;

class BasePathGenerator extends PathGenerator
{ 
    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        return  $media->created_at->format('Y').'/'.
                $media->created_at->format('W').'/'.
                $media->getKey().'/';
    }
}
