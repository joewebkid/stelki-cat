<?php

namespace app\components\image;

use yii\base\Component;
use Yii;

class Resize extends Component
{

    var $image;
    var $image_type;
    var $rand_name;
    var $path;
    var $path_short;

    function load($filename)
    {
        $this->path_short = 'resize/';
        $this->path = Yii::getAlias('@webroot') . '/uploads/' . $this->path_short;

        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }

        return $this;
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
    {
        if (!$filename) {
            $this->setRandName();
            $filename = $this->path . $this->rand_name;
        }

        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }

        return $this->path_short . $this->rand_name;
    }

    function output($image_type = IMAGETYPE_JPEG)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }

        return $this;
    }

    function getWidth()
    {
        return imagesx($this->image);
    }

    function getHeight()
    {
        return imagesy($this->image);
    }

    function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);

        return $this;
    }

    function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);

        return $this;
    }

    function setRandName()
    {
        $name = time() . rand(000, 999);
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->rand_name = $name . '.jpg';
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->rand_name = $name . '.gif';
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->rand_name = $name . '.png';
        }

        return $this;
    }

    function scale($scale)
    {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);

        return $this;
    }

    function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;

        return $this;
    }

    function resizeAuto($max)
    {
        $thumb_w = $max;
        $thumb_h = $max;

        $old_x = $this->getWidth();
        $old_y = $this->getHeight();

        if ($old_x > $max || $old_y > $max) {
            if ($old_x > $old_y) {
                $thumb_w = $max;
                $thumb_h = $old_y * ($max / $old_x);
            }

            if ($old_x < $old_y) {
                $thumb_w = $old_x * ($max / $old_y);
                $thumb_h = $max;
            }

            if ($old_x == $old_y) {
                $thumb_w = $max;
                $thumb_h = $max;
            }
        }

        $new_image = imagecreatetruecolor($thumb_w, $thumb_h);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $thumb_w, $thumb_h, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;

        return $this;
    }
}