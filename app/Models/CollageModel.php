<?php

declare(strict_types=1);

namespace App\Models;

use Image;
use Illuminate\Http\Response;

class CollageModel
{
    private const WIDTH = 362;

    private const HEIGHT = 544;

    private const IN_LINE = 5;

    private const GAP = 10;

    /**
     * Get main collage image
     *
     * @return Response
     */
    public function getCollage(): Response
    {
        $images = self::getImages();
        $rows = ceil(sizeof($images) / self::IN_LINE);

        $finalImage = Image::canvas(
            self::getTotalSize(self::WIDTH, self::IN_LINE),
            self::getTotalSize(self::HEIGHT, $rows)
        );

        // Add all other images
        foreach ($images as $index => $image) {
            $row = floor($index / self::IN_LINE);
            $col = ($index % self::IN_LINE);

            $finalImage->insert(
                $image,
                'top-left',
                self::getLocation(self::WIDTH, $col),
                self::getLocation(self::HEIGHT, $row)
            );
        }

        return $finalImage->response('png');
    }

    /**
     * Get total width or height of the canvas
     *
     * @param float $dimension
     * @param float $count
     * @return float
     */
    private function getTotalSize(float $dimension, float $count): float
    {
        return ($dimension * $count) + (self::GAP * ($count - 1));
    }

    /**
     * Get location from top-left for width or height including gap
     *
     * @param float $size
     * @param float $count
     * @return float
     */
    private function getLocation(float $dimension, float $count): float
    {
        return ($dimension * $count) + (($count > 0) ? self::GAP * $count : 0);
    }

    /**
     * Get all images from assets folder in order
     *
     * @return array
     */
    private function getImages(): array
    {
        $path = public_path('assets');
        $images = glob($path . "/*.png");
        natsort($images); // sort by name
        return array_values($images); // reindex array
    }
}
