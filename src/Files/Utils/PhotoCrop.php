<?php
namespace JI\Files\Utils;

use Exception;
use GdImage;
use function exif_read_data;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class PhotoCrop {

  private const ORIENTATIONS = [
    3 => 180,
    5 => -90,
    6 => -90,
    7 => -90,
    8 => 90,
  ];

  private const FLIP_ORIENTATIONS = [
    2 => IMG_FLIP_HORIZONTAL,
    4 => IMG_FLIP_VERTICAL,
    5 => IMG_FLIP_VERTICAL,
    7 => IMG_FLIP_HORIZONTAL,
  ];

  private const SUPPORTED_MIME = [
    'pjpeg',
    'jpeg',
    'gif',
    'png'
  ];


  private ?string $path;
  private ?GdImage $image;

  private int $width  = 0;
  private int $height = 0;
  private ?string $mime  = null;

  public static function create(string $local_path): ?self {
    return (new self())
      ->setPath($local_path)
      ->process();
  }

  private function setPath(?string $path): self {
    $this->path = $path;
    return $this;
  }

  private function process(): ?self {
    if (!$this->path) {
      return null;
    }
    $info = @getimagesize($this->path);
    if (!$info || !$info['mime']) {
      return null;
    }
    $this->mime = strtolower(substr($info['mime'], 6));
    return $this->loadImage();
  }

  private function loadImage(): ?self {
    if (!in_array($this->mime, self::SUPPORTED_MIME)) {
      return null;
    }
    $image = match ($this->mime) {
      'jpeg', 'pjpeg' => imagecreatefromjpeg($this->path),
      'png'   => imagecreatefrompng($this->path),
      'gif'   => imagecreatefromgif($this->path),
      default => null,
    };
    if (!$image) {
      return null;
    }
    return $this->setImage($image);
  }


  private function setImage(GdImage $image): ?self {
    $this->image = $image;
    $this->width = @imagesx($this->image);
    $this->height = @imagesy($this->image);
    return $this;
  }

  private function destroy() {
    imagedestroy($this->image);
    $this->image = null;
  }

  public function scale($size = 100, $auto = false) {
    if ($auto && $this->width < $size) {
      $size = $this->width;
    } elseif ($this->width < $size || $this->height < $size) {
      $size = ($this->width < $this->height) ? $this->width : $this->height;
    }
    $new_height = $size;
    $new_width = $size;
    if ($auto) {
      $new_height = (int)floor(($size / $this->width) * $this->height);
    }
    $new_image = imagecreatetruecolor($new_width, $new_height);
    if ($this->mime === 'png') {
      imagealphablending($new_image, false);
      $transparent_image = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagefill($new_image, 0, 0, $transparent_image);
      imagesavealpha($new_image, true);
    }
    imagecopyresampled($new_image, $this->image,0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
    $this->setImage($new_image);
    return $this;
  }

  public function flip($mode)  {
    imageflip($this->image, $mode);
  }

  public function orientation() {
    $exif = @exif_read_data($this->path);
    $orientation = (int)$exif['Orientation'];
    if (!$orientation) {
      return $this;
    }
    if (array_key_exists($orientation, self::FLIP_ORIENTATIONS)) {
      $flip = self::FLIP_ORIENTATIONS[$orientation];
      $this->flip($flip);
    }
    if (array_key_exists($orientation, self::ORIENTATIONS)) {
      $angle = self::ORIENTATIONS[$orientation];
      $this->rotate($angle);
    }
    return $this;
  }

  public function rotate($angle = 90) {
    $image = imageColorAllocateAlpha($this->image, 0, 0, 0, 127);
    $this->setImage(imagerotate($this->image, $angle, $image));
    return $this;
  }


  public function square() {
    $scale = $this->width;
    $x = 0;
    $y = 0;
    if ($this->width > $this->height) {
      $x = ($this->width - $this->height) / 2;
      $scale = $this->height;
    } elseif ($this->height > $this->width) {
      $y = ($this->height - $this->width) / 2;
      $scale = $this->width;
    }
    return $this->crop($scale, $scale, (int)floor($x), (int)floor($y));
  }

  public function crop($new_width, $new_height, $x = 0, $y = 0) {
    if($this->width < $new_width) {
      $new_width = $this->width;
    }
    if ($this->height < $new_height) {
      $new_height = $this->height;
    }
    $new_image = @imagecreatetruecolor($new_width, $new_height);
    $image_color_allocated = @imagecolorallocate($this->image, 255, 255, 255);
    @imagefill($new_image, 0, 0, $image_color_allocated);
    @imagecopy($new_image, $this->image, 0, 0, $x, $y, $new_width, $new_height);
    $this->setImage($new_image);
    return $this;
  }

  public function save(string $new_file, $quality = 90): self {
    if ($quality <= 0 || $quality > 100) {
      throw new Exception('Unsupported quality');
    }
    imageinterlace($this->image, true);
    imagejpeg($this->image, $new_file, $quality);
    return $this;
  }


  public function getOputputPNG(): ?string {
    if ($this->mime !== 'png') {
      return null;
    }
    ob_start();
    imageinterlace($this->image, true);
    imagepng($this->image, null, 1);
    $content = ob_get_clean();
    if (!$content) {
      return null;
    }
    return (string)$content;
  }


  public function getOutputJPG(int $quality = 90): ?string {
    ob_start();
    imageinterlace($this->image, true);
    imagejpeg($this->image, null, $quality);
    $content = ob_get_clean();
    if (!$content) {
      return null;
    }
    return $content;
  }

}
