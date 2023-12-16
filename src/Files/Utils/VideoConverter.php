<?php
namespace JI\Files\Utils;


/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class VideoConverter {
  private $debug_mode = false;
  private $file;
  private $info       = [];
  private $debug      = [];

  private const BIN_FFPROBE     = 'ffprobe';
  private const BIN_FFMPEG      = 'ffmpeg';

  private const EXT_JPG         = '.jpg';
  private const EXT_MP4         = '.mp4';

  private const VIDEO_CODEC     = 'libx264';


  // Sizes
  public const SIZE_96_SQCIF    = 'sqcif';
  public const SIZE_144_QCIF    = 'qcif';
  public const SIZE_288_CIF     = 'cif';
  public const SIZE_576_4CIF    = '4cif';
  public const SIZE_1152_16CIF  = '16cif';
  public const SIZE_120_QQVGA   = 'qqvga';
  public const SIZE_240_QVGA    = 'qvga';
  public const SIZE_480_VGA     = 'vga';
  public const SIZE_600_SVGA    = 'svga';
  public const SIZE_768_XGA     = 'xga';
  public const SIZE_1200_UXGA   = 'uxga';
  public const SIZE_1536_QXGA   = 'qxga';
  public const SIZE_1024_SXGA   = 'sxga';
  public const SIZE_2048_QSXGA  = 'qsxga';
  public const SIZE_4096_HSXGA  = 'hsxga';
  public const SIZE_480_WVGA    = 'wvga';
  public const SIZE_768_WXGA    = 'wxga';
  public const SIZE_1024_WSXGA  = 'wsxga';
  public const SIZE_1200_WUXGA  = 'wuxga';
  public const SIZE_1600_WOXGA  = 'woxga';
  public const SIZE_2048_WQSXGA = 'wqsxga';
  public const SIZE_2400_WQUXGA = 'wquxga';
  public const SIZE_4096_WHSXGA = 'whsxga';
  public const SIZE_4800_WHUXGA = 'whuxga';
  public const SIZE_200_CGA     = 'cga';
  public const SIZE_350_EGA     = 'ega';
  public const SIZE_480_HD480   = 'hd480';
  public const SIZE_720_HD720   = 'hd720';
  public const SIZE_1080_HD1080 = 'hd1080';

  // Eg: {SIZE} => [{WIDTH}, {HEIGHT}]
  private const SCALE_SIZES = [
    self::SIZE_96_SQCIF    => [128, 96],
    self::SIZE_144_QCIF    => [176, 144],
    self::SIZE_288_CIF     => [352, 288],
    self::SIZE_576_4CIF    => [704, 576],
    self::SIZE_1152_16CIF  => [1408, 1152],
    self::SIZE_120_QQVGA   => [160, 120],
    self::SIZE_240_QVGA    => [320, 240],
    self::SIZE_480_VGA     => [640, 480],
    self::SIZE_600_SVGA    => [800, 600],
    self::SIZE_768_XGA     => [1024, 768],
    self::SIZE_1200_UXGA   => [1600, 1200],
    self::SIZE_1536_QXGA   => [2048, 1536],
    self::SIZE_1024_SXGA   => [1280, 1024],
    self::SIZE_2048_QSXGA  => [2560, 2048],
    self::SIZE_4096_HSXGA  => [5120, 4096],
    self::SIZE_480_WVGA    => [852, 480],
    self::SIZE_768_WXGA    => [1366, 768],
    self::SIZE_1024_WSXGA  => [1600, 1024],
    self::SIZE_1200_WUXGA  => [1920, 1200],
    self::SIZE_1600_WOXGA  => [2560, 1600],
    self::SIZE_2048_WQSXGA => [3200, 2048],
    self::SIZE_2400_WQUXGA => [3840, 2400],
    self::SIZE_4096_WHSXGA => [6400, 4096],
    self::SIZE_4800_WHUXGA => [7680, 4800],
    self::SIZE_200_CGA     => [320, 200],
    self::SIZE_350_EGA     => [640, 350],
    self::SIZE_480_HD480   => [852, 480],
    self::SIZE_720_HD720   => [1280, 720],
    self::SIZE_1080_HD1080 => [1920, 1080],
  ];

  // Log events
  private const LOG_EVENT_LOAD_INFO_START   = 'LOAD_INFO_START';
  private const LOG_EVENT_LOAD_INFO_FINISH  = 'LOAD_INFO_FINISH';
  private const LOG_EVENT_SCREENSHOT_START  = 'SCREENSHOT_START';
  private const LOG_EVENT_SCREENSHOT_FINISH = 'SCREENSHOT_FINISH';
  private const LOG_EVENT_CONVERT_START     = 'CONVERT_START';
  private const LOG_EVENT_CONVERT_FINISH    = 'CONVERT_FINISHED';


  public static function create($file): self {
    return new self($file);
  }

  private function clearInfo() {
    $this->info = [];
  }

  public function setDebugMode(bool $debug_mode) {
    $this->debug_mode = $debug_mode;
  }

  private function logEvent(mixed ...$args) {
    if ($this->debug_mode) {
      $time = (string)microtime(true);
      $this->debug[$time] = $args;
    }
  }

  public function getDebugLog(): array {
    return $this->debug;
  }

  private function setInfo(array $info) {
    $format = $info['format'];
    $stream = array_shift($info['streams']);
    $this->info = [
      'duration' => (int)$format['duration'],
      'width'    => (int)$stream['width'],
      'height'   => (int)$stream['height'],
    ];
  }

  private function deleteFile() {
    if (strpos($this->file, '://')) {
      return;
    }
    @unlink($this->file);
  }

  public function destroy(bool $delete_file = false) {
    if ($delete_file) {
      $this->deleteFile();
    }
    $this->file = '';
    $this->info = [];
    $this->clearInfo();
  }

  private function exec(string $command): ?string {
    $info = null;
    exec($command, $info);
    if (is_array($info)) {
      return implode(PHP_EOL, $info);
    }
    return $info;
  }


  private function prepareVideo() {
    if (!$this->info) {
      $this->logEvent(self::LOG_EVENT_LOAD_INFO_START);
      $result = $this->exec(self::BIN_FFPROBE." -v quiet -print_format json -show_format -select_streams v:0 -show_entries stream=height,width {$this->file}");
      $info = false;
      if ($result) {
        $info = json_decode($result, true);
      }
      if (!is_array($info)) {
        $this->destroy(true);
        throw new \Exception('Incorrect video format');
      }
      $this->setInfo($info);
      $this->logEvent(self::LOG_EVENT_LOAD_INFO_FINISH, $result);
    }
  }

  public function getDuration(): int {
    return $this->info['duration']?: 0;
  }

  public function __construct(string $file) {
    $this->file = $file;
    $this->prepareVideo();
    return $this;
  }

  /**
   * @return ?int[]
   */
  private function getSize(string $size): ?array {
    if (array_key_exists($size, self::SCALE_SIZES)) {
      return self::SCALE_SIZES[$size];
    }
    return null;
  }

  public function screenshot(string $file_name, int $second = null, string|int $size = 0): self {
    $this->logEvent(self::LOG_EVENT_SCREENSHOT_START);
    $scale = '';
    if ($size) {
      if (is_numeric($size)) {
        $scale = '-filter:v scale="-1:min('.$size.'\, ih)"';
      } else {
        $scale_info = $this->getSize($size);
        if ($scale_info === null) {
          throw new \Exception('Unknown screenshot size');
        }
        [, $height] = $scale_info;
        $scale = '-filter:v scale="-1:min('.$height.'\, ih)"';
      }
    }
    if ($second === null) {
      $second = (int)$this->getDuration() / 2;
    }
    $file_name_full = $file_name.self::EXT_JPG;
    $result = $this->exec(self::BIN_FFMPEG." -y -i {$this->file} -f mjpeg -vframes 1 {$scale} -ss {$second} {$file_name_full} 2>&1");
    if (strpos($result, $file_name_full) === false) {
      throw new \Exception('Cant take screenshot');
    }
    $this->logEvent(self::LOG_EVENT_SCREENSHOT_FINISH, $result);
    return $this;
  }


  public function manyScreenshots(string $file_name_prefix, int $count = 1, int|string $size = 0): self {
    $second_part       = $this->getDuration() / $count;
    $current_second = 0;
    for ($i = 1; $i <= $count; $i++) {
      $file_name = $file_name_prefix.'.'.$i;
      $this->screenshot($file_name, $current_second, $size);
      $current_second += $second_part;
    }
    return $this;
  }

  private function canCrop(string $size): bool {
    $info = $this->getSize($size);
    if ($info === null) {
      throw new \Exception('Unknown crop size');
    }
    [$width, $height] = $info;
    return $this->info['width'] >= $width && $this->info['height'] >= $height;
  }

  public function saveMP4(string $file_name, ?string $size = null): self {
    $file_name_full = $file_name.self::EXT_MP4;
    $crop = '';
    if ($size !== null && $this->canCrop($size)) {
      $crop = "-s {$size}";
    }
    $this->logEvent(self::LOG_EVENT_CONVERT_START);
    $result = $this->exec(self::BIN_FFMPEG." -i {$this->file} -vcodec ".self::VIDEO_CODEC." {$crop} -c:a aac {$file_name_full} 2>&1");
    $this->logEvent(self::LOG_EVENT_CONVERT_FINISH, $result);
    return $this;
  }
}
