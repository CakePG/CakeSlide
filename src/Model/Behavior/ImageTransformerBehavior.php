<?php
namespace CakePG\CakeSlide\Model\Behavior;

use Cake\ORM\Behavior;

/**
 * Modified 2017.11.23
 */
class ImageTransformerBehavior extends Behavior
{
    /**
     * アップロードの画像加工処理
     */
    public function imageTransformer($data, $type, $setting, $tmp)
    {
          // 画像からgdオブジェクトを作成
          $imgOrigin = imagecreatefromstring(file_get_contents($data['tmp_name']));
          // 位置情報データ取得
          $exifDatas = @exif_read_data($data['tmp_name']);
          // Orientation設定があった場合に画像の回転処理
          $imgOrigin = $this->fixOrientation($imgOrigin, $exifDatas);
          // 画像サイズ取得
          $widthOrigin = imagesx($imgOrigin);
          $heightOrigin = imagesy($imgOrigin);

          // 画像のサイズからリサイズするかを判定
          $resize = true;
          // 固定の場合
          if (!empty($setting['fixed'])) {
            $rate = $setting['fixed'][0] / $widthOrigin;
            $heightTmp = ceil($heightOrigin*$rate);
            $widthProcess = $setting['fixed'][0];
            $heightProcess = $setting['fixed'][1];
            if ($setting['fixed'][1] <= $heightTmp) {
              $offsetX = 0;
              $offsetY = ($heightTmp - $setting['fixed'][1]) / 2 / $rate;
              $heightOrigin = $heightOrigin - ($offsetY * 2);
            // 縦のサイズが足りない
            } else {
              $rate = $setting['fixed'][1] / $heightOrigin;
              $widthTmp = ceil($widthOrigin*$rate);
              $offsetX = ($widthTmp - $setting['fixed'][0]) / 2 / $rate;
              $offsetY = 0;
              $widthOrigin = $widthOrigin - ($offsetX * 2);
            }
          // 横幅の最大値制限
          } elseif ($setting['maxwidth']) {
            if ($widthOrigin > $setting['maxwidth']) {
              $rate = $setting['maxwidth'] / $widthOrigin;
              $widthProcess = $setting['maxwidth'];
              $heightProcess = ceil($heightOrigin*$rate);
              $offsetX = 0;
              $offsetY = 0;
            } else {
              $resize = false;
            }
          // 縦幅の最大値制限
          } elseif ($setting['maxheight']) {
            if ($heightOrigin > $setting['maxheight']) {
              $rate = $setting['maxheight'] / $heightOrigin;
              $widthProcess = ceil($widthOrigin*$rate);
              $heightProcess = $setting['maxheight'];
              $offsetX = 0;
              $offsetY = 0;
            } else {
              $resize = false;
            }
          } else {
            $resize = false;
          }

          if ($resize) {
            // 画像サイズの変更処理
            $imgProcess = imagecreatetruecolor($widthProcess, $heightProcess);
            imagecopyresampled($imgProcess, $imgOrigin, 0, 0, $offsetX, $offsetY, $widthProcess, $heightProcess, $widthOrigin, $heightOrigin);
            imagedestroy($imgOrigin);
            $imgOrigin = $imgProcess;
          }

          // mask処理
          if ($setting['mask']) {
            list($widthMask, $heightMask) = getimagesize($setting['mask']);
            $imgMask = imagecreatefrompng($setting['mask']);
            // maskのキャンバス用意
            $imgCanvas = imagecreatetruecolor($widthMask, $heightMask);
            imagealphablending($imgCanvas, false);
            imagesavealpha($imgCanvas, true);
            $transparent = imagecolorallocatealpha($imgCanvas, 0, 0, 0, 127);
            imagefill($imgCanvas, 0, 0, $transparent);
            // mask反映
            for($y = 0; $y < $heightMask; $y++){
              for($x = 0; $x < $widthMask; $x++){
                $rgb = imagecolorat($imgMask, $x, $y);
                $index = imagecolorsforindex($imgMask, $rgb);
                $alpha = $index['alpha']; //$alpha = ($index['red'] + $index['green'] + $index['blue']) / 765 * 127 ;
                // $alpha = 127 - $alpha;
                $current = imagecolorat($imgOrigin, $x, $y);
                $index = imagecolorsforindex($imgOrigin, $current);
                $color = imagecolorallocatealpha($imgCanvas, $index['red'], $index['green'], $index['blue'], $alpha);
                imagesetpixel($imgCanvas, $x, $y, $color);
              }
            }
            // maskの場合はpngのみ
            imagepng($imgCanvas, $tmp);
            imagedestroy($imgMask);
            imagedestroy($imgCanvas);
          } else {
            if ($type == 'image/png') imagepng($imgOrigin, $tmp);
            elseif ($type == 'image/bmp') imagebmp($imgOrigin, $tmp);
            else imagejpeg($imgOrigin, $tmp, $setting['quality']);
          }
          imagedestroy($imgOrigin);
          return $tmp;
    }

    // Orientation設定があった場合に画像の回転処理
    protected function fixOrientation($imgOrigin, $exifDatas)
    {
        if(!empty($exifDatas['Orientation'])){
            switch ($exifDatas['Orientation']) {
              case 2:
                imageflip($imgOrigin, IMG_FLIP_HORIZONTAL);
                break;
              case 3:
                $imgOrigin = imagerotate($imgOrigin, 180, 0);
                break;
              case 4:
                imageflip($imgOrigin, IMG_FLIP_VERTICAL);
                break;
              case 5:
                $imgOrigin = imagerotate($imgOrigin, 270, 0);
                imageflip($imgOrigin, IMG_FLIP_HORIZONTAL);
                break;
              case 6:
                $imgOrigin = imagerotate($imgOrigin, 270, 0);
                break;
              case 7:
                $imgOrigin = imagerotate($imgOrigin, 90, 0);
                imageflip($imgOrigin, IMG_FLIP_HORIZONTAL);
                break;
              case 8:
                $imgOrigin = imagerotate($imgOrigin, 90, 0);
                break;
            }
        }
        return $imgOrigin;
    }
}
