<?php

/**
 * Компонент ImageResizeHelperComponent
 * Работает с изображениями,
 * уменьшает размеры, обрезает, может поменять фото.
 *при загрузке фотографий на сайт, используется для уменьшения размера превью фото.
 */

namespace app\components;

use Yii;
use yii\base\BaseObject;
use yii\base\Component;
use yii\helpers\FileHelper;

/**
 * Изменение размеров с обрезкой и без на лету
 *
 * Примеры:
 * echo Html::img(ImageResizeHelper::init()->image('uploads/pic.jpg')->crop(500, 500));
 * echo Html::img(ImageResizeHelper::init()->image('uploads/pic.jpg')->quality(95)->fit(500, 500));
 * echo Html::img(ImageResizeHelper::init()->image('uploads/pic.jpg'image)->fitWidth(500));
 * echo Html::img(ImageResizeHelper::init()->image('uploads/pic.jpg')->fitHeight(500));
 * echo Html::img(ImageResizeHelper::init()->image('uploads/pic.jpg')->background('ffcccc')->place(500, 500));
 */
class ImageResizeHelperComponent extends Component {
    /**
     * @var self
     */

    /**
     * @var string Путь к папке сайта
     */
    public $siteRoot;

    /**
     * @var string Путь к папке resized
     */
    public $urlMinPhoto;

    /**
     * @var string Ссылка на папку resized
     */
    public $absUrlMinPhoto;

    /**
     * @var int JPEG качество генерируемых картиноу
     */
    public $quality;

    /**
     * @var string Относительная ссылка на оригинальную картинку
     */
    public $origImageFull;

    /**
     * @var string Путь к картинке по-умолчанию, если не найден оригинал.
     */
    public $defaultImage;

    /**
     * @var array Цвет основы
     */
    public $bg;

    public $_im;
    public $newImageUrl;
    public $newImagePath;

    public function __construct($config = []) {

        parent::__construct($config);
    }

    public function init() {
        parent::init(); //

    }

    /**
     * Задать ссылку на картинку
     *
     * @param string $imageUrl
     *
     * @return $this
     */
    public function image($imageUrl) {
        $this->origImageFull = $imageUrl;
        return $this;
    }

    /**
     * Задать абсолютный путь к папке img
     *
     * @param string $path
     *
     * @return $this
     */
    public function cachePath($path) {
        $this->urlMinPhoto = $path;
        return $this;
    }

    /**
     * Задать ссылку на папку img
     *
     * @param string $url
     *
     * @return $this
     */
    public function cacheUrl($url) {
        $this->absUrlMinPhoto = $url;
        return $this;
    }

    /**
     * Задать качество JPEG
     *
     * @param int $quality
     *
     * @return $this
     */
    public function quality($quality) {
        $this->quality = (int)$quality;
        if ($this->quality > 100)
            $this->quality = 100;
        if ($this->quality < 1)
            $this->quality = 1;
        return $this;
    }

    /**
     * Задать картинку по-умолчанию
     *
     * @param string $image
     *
     * @return $this
     */
    public function defaultImage($image) {
        $this->defaultImage = $image;
        return $this;
    }

    /**
     * Задает цвет основы
     *
     * @param string $hex
     *
     * @return $this
     */
    public function background($hex) {
        $this->bg = $this->_hex2rgb($hex);
        return $this;
    }

    /**
     * Изменение размеров с обрезанием до нужных размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $forceResize
     *
     * @return string Путь к сгенерированной картинке
     */
    public function crop($width, $height, $forceResize = false) {
        return $this->resize($width, $height, true, '', $forceResize);
    }

    /**
     * Изменение размеров с вписыванием по ширине и высоте
     *
     * @param int $width
     * @param int $height
     * @param bool $forceResize
     *
     * @return string Путь к сгенерированной картинке
     */
    public function fit($width, $height, $forceResize = false) {
        return $this->resize($width, $height, false, '', $forceResize);
    }

    /**
     * Изменить до нужной ширины
     *
     * @param int $width
     * @param bool $forceResize
     *
     * @return string
     */
    public function fitWidth($width, $forceResize = false) {
        return $this->resize($width, $width, false, 'w', $forceResize);
    }

    /**
     * Изменить до нужной высоты
     *
     * @param int $height
     * @param bool $forceResize
     *
     * @return string
     */
    public function fitHeight($height, $forceResize = false) {
        return $this->resize($height, $height, false, 'h', $forceResize);
    }

    /**
     * картинка вмещается в заданные размеры и помещается на подложку этих размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $forceResize
     *
     * @return string
     */
    public function place($width, $height, $forceResize = false) {
        return $this->resize($width, $height, false, 'p', $forceResize);
    }

    /**
     * Изменение размеров с вписыванием по ширине и/или высоте или с обрезанием до нужных размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @param string $fitwh 'w' или 'h'
     * @param bool $forceResize Форсировать генерацию, если исходные и конечные размеры одинаковы
     *
     * @return string Путь к сгенерированной картинке
     */
    private function resize($width, $height, $crop = true, $fitwh = '', $forceResize = false) {
        //       return $this->siteRoot;
        //       return $this->urlMinPhoto;
        //       return $this->absUrlMinPhoto;
        $orig_image_url = $this->origImageFull;
        $full_path = $this->origImageFull;
        $width = (int)$width;
        $height = (int)$height;
        $mimeType = FileHelper::getMimeType($full_path);

        // размеры исходного изображения
        $sizes = getimagesize($full_path);
        $w = $sizes[0];
        $h = $sizes[1];

        // имя и путь к новой картинке (все в JPEG)
        $new_filename = time() * rand(99999, 100000000) + rand(1, 1000) . '.jpg';
        $new_folder_p1 = $width . 'x' . $height;
        if (!$crop && $fitwh == 'w')
            $new_folder_p1 = $width;
        if (!$crop && $fitwh == 'h')
            $new_folder_p1 = $height;
        $new_folder_p1 .= '-q' . $this->quality;
        if ($this->bg['r'] != 255 || $this->bg['g'] != 255 || $this->bg['b'] != 255)
            $new_folder_p1 .= '-' . $this->_rgb2hex($this->bg);
        if ($crop)
            $new_folder_p1 .= '-crop';
        if (!$crop && $fitwh == 'w')
            $new_folder_p1 .= '-fitw';
        if (!$crop && $fitwh == 'h')
            $new_folder_p1 .= '-fith';

        // новая ссылка и абсолютный путь
        $this->newImageUrl = $this->absUrlMinPhoto . '/' . $new_filename;
        $this->newImagePath = $this->urlMinPhoto . DIRECTORY_SEPARATOR . $new_filename;

        // создаем ресурс из исходной картинки
        $this->_im = false;
        switch ($mimeType) {
            case 'image/gif':
                $this->_im = imagecreatefromgif($full_path);
                break;
            case 'image/jpeg':
                $this->_im = imagecreatefromjpeg($full_path);
                break;
            case 'image/png':
                $this->_im = imagecreatefrompng($full_path);
                break;
            default :
                return $full_path;
        }

        if ($this->_im !== false) {

            $dst_x = 0;
            $dst_y = 0;
            $x = 0;
            $y = 0;

            // обрезать по ширине и высоте (hard crop)
            if ($crop) {
                $ratio = max($width / $w, $height / $h);
                $new_w = round($w * $ratio);
                $new_h = round($h * $ratio);
                $x = round(($w - $width / $ratio) / 2);
                $y = round(($h - $height / $ratio) / 2);
            } // вместить по ширине (высота может быть и меньше, и больше)
            elseif ($fitwh == 'w') {
                $new_w = $width;
                $new_h = $new_w / $w * $h;
                // зададим новые размеры готовой картинки
                $width = $new_w;
                $height = $new_h;
            } // вместить по высоте (ширина может быть и меньше, и больше)
            elseif ($fitwh == 'h') {
                $new_h = $height;
                $new_w = $new_h * $w / $h;
                // зададим новые размеры готовой картинки
                $width = $new_w;
                $height = $new_h;
            } // вместить по ширине и высоте и разместить на обложке указанных размеров
            elseif ($fitwh == 'p') {
                $ratio = min($width / $w, $height / $h);
                $new_w = round($w * $ratio);
                $new_h = round($h * $ratio);
                $dst_x = round(($width - $new_w) / 2);
                $dst_y = round(($width - $new_h) / 2);
            } // вместить по ширине и высоте
            else {
                $ratio = min($width / $w, $height / $h);
                $new_w = round($w * $ratio);
                $new_h = round($h * $ratio);
                // зададим новые размеры готовой картинки
                $width = $new_w;
                $height = $new_h;
            }

            // создание и копирование
            $this->saveImage($width, $height, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h);

            // новый путь
            if (is_file($this->newImagePath))
                return $this->newImageUrl;
        }

        return $full_path;
    }

    /**
     * @param int $width
     * @param int $height
     * @param int $dst_x
     * @param int $dst_y
     * @param int $x
     * @param int $y
     * @param int $new_w
     * @param int $new_h
     * @param int $w
     * @param int $h
     */

    private function saveImage($width, $height, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h) {
        // создание и копирование
        $new_im = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($new_im, $this->bg['r'], $this->bg['g'], $this->bg['b']);
        imagefill($new_im, 0, 0, $bg_color);
        imagecopyresampled($new_im, $this->_im, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h);

        // сохранение
        // все в JPEG
        imagejpeg($new_im, $this->newImagePath, $this->quality);

        imagedestroy($this->_im);
        imagedestroy($new_im);
    }

    /**
     * Преобразует строку с HEX-цветом в массив RGB
     *
     * @param string $hex
     *
     * @return array
     */
    private function _hex2rgb($hex) {
        $hex = str_replace('#', '', $hex);
        if (!preg_match('/^[0-9a-f]+$/', $hex))
            return ['r' => 255, 'g' => 255, 'b' => 255];

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    /**
     * Преобразует массив RGB в строку с HEX-цветом
     *
     * @param array $rgb
     * @return string
     */
    private function _rgb2hex($rgb) {
        $hex = '';
        $hex .= str_pad(dechex($rgb['r']), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb['g']), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb['b']), 2, '0', STR_PAD_LEFT);

        return $hex;
    }
}