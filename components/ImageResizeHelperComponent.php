<?php

namespace app\components;

use Yii;
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
class ImageResizeHelperComponent {
    /**
     * @var self
     */

    /**
     * @var string Путь к папке сайта
     */
    private $_siteRoot;

    /**
     * @var string Путь к папке resized
     */
    private $_urlMinPhoto;

    /**
     * @var string Ссылка на папку resized
     */
    private $absUrlMinPhoto;

    /**
     * @var int JPEG качество генерируемых картиноу
     */
    private $_quality;

    /**
     * @var string Относительная ссылка на оригинальную картинку
     */
    private $_origImageFull;

    /**
     * @var string Путь к картинке по-умолчанию, если не найден оригинал.
     */
    private $_defaultImage;

    /**
     * @var array Цвет основы
     */
    private $_bg;

    private $_im;
    private $_newImageUrl;
    private $_newImagePath;

    /**
     * @var array mime-типы изображений
     */
    private $_mimeTypesImages = ['image/gif', 'image/jpeg', 'image/png'];

    /**
     * ImageResizeHelper::init()->image('uploads/image.jpg')->quality(70)->crop(100, 100);
     *
     * @return self
     */
    public static function init() {
        $class_name = __CLASS__;
        return new $class_name;
    }

    /**
     * __construct
     */
    public function __construct() {
        $this->_siteRoot = Yii::getAlias('@webroot');
        $this->_urlMinPhoto = Yii::$app->session->get('path') . '/min';
        $this->absUrlMinPhoto = '/img/orders/' . Yii::$app->session->get('folder') . '/min';
        $this->_quality = 85;
        $this->_defaultImage = dirname(__FILE__) . '/imageresize/noimage.png';
        $this->_bg = ['r' => 255, 'g' => 255, 'b' => 255];
    }

    /**
     * Задать ссылку на картинку
     *
     * @param string $imageUrl
     *
     * @return $this
     */
    public function image($imageUrl, $name) {
        $this->_origImageFull = $imageUrl;
        $this->_origName = $name;
        return $this;
    }

    /**
     * Задать абсолютный путь к папке resized
     *
     * @param string $path
     *
     * @return $this
     */
    public function cachePath($path) {
        $this->_urlMinPhoto = $path;
        return $this;
    }

    /**
     * Задать ссылку на папку resized
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
        $this->_quality = (int)$quality;
        if ($this->_quality > 100)
            $this->_quality = 100;
        if ($this->_quality < 1)
            $this->_quality = 1;
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
        $this->_defaultImage = $image;
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
        $this->_bg = $this->_hex2rgb($hex);
        return $this;
    }

    /**
     * Изменение размеров с обрезанием до нужных размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $force_resize
     *
     * @return string Путь к сгенерированной картинке
     */
    public function crop($width, $height, $force_resize = false) {
        return $this->_resize($width, $height, true, '', $force_resize);
    }

    /**
     * Изменение размеров с вписыванием по ширине и высоте
     *
     * @param int $width
     * @param int $height
     * @param bool $force_resize
     *
     * @return string Путь к сгенерированной картинке
     */
    public function fit($width, $height, $force_resize = false) {
        return $this->_resize($width, $height, false, '', $force_resize);
    }

    /**
     * Изменить до нужной ширины
     *
     * @param int $width
     * @param bool $force_resize
     *
     * @return string
     */
    public function fitWidth($width, $force_resize = false) {
        return $this->_resize($width, $width, false, 'w', $force_resize);
    }

    /**
     * Изменить до нужной высоты
     *
     * @param int $height
     * @param bool $force_resize
     *
     * @return string
     */
    public function fitHeight($height, $force_resize = false) {
        return $this->_resize($height, $height, false, 'h', $force_resize);
    }

    /**
     * картинка вмещается в заданные размеры и помещается на подложку этих размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $force_resize
     *
     * @return string
     */
    public function place($width, $height, $force_resize = false) {
        return $this->_resize($width, $height, false, 'p', $force_resize);
    }

    /**
     * Изменение размеров с вписыванием по ширине и/или высоте или с обрезанием до нужных размеров
     *
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @param string $fitwh 'w' или 'h'
     * @param bool $force_resize Форсировать генерацию, если исходные и конечные размеры одинаковы
     *
     * @return string Путь к сгенерированной картинке
     */
    private function _resize($width, $height, $crop = true, $fitwh = '', $force_resize = false) {
        //       return $this->_siteRoot;
        //       return $this->_urlMinPhoto;
        //       return $this->absUrlMinPhoto;
        $orig_image_url = $this->_origImageFull;

        $width = (int)$width;
        $height = (int)$height;
        // если не задааны размеры - используем _defaultImage
        if ($width <= 0 || $height <= 0) {
            $full_path = $this->_defaultImage;
        } else {
            // приведем путь к нужному виду
            //            $this->_clearImagePath();

            // абсолютный путь к картинке
            //            $full_path = $this->_getFullPath();
            $full_path = $this->_origImageFull;
            // если картинки нет - используем _defaultImage
            if (!is_file($full_path))
                $full_path = $this->_defaultImage;
        }


        // если даже _defaultImage не найден, вернем ничего
        if (!is_file($full_path))
            return 'Нет никакого изображения';

        // получим mime-тип
        $mimeType = FileHelper::getMimeType($full_path);
        if ($mimeType === null) {
            return 'не определен mime';
        }

        // не тот mime-тип
        if (!in_array($mimeType, $this->_mimeTypesImages)) {
            return 'mime не тот';
        }

        // размеры исходного изображения
        $sizes = getimagesize($full_path);
        if (!$sizes) {
            return '';
        }
        $w = $sizes[0];
        $h = $sizes[1];
        if ($w == 0 || $h == 0) {
            return 'размеры исходного фото равны нулю';
        }

        // проверим размеры исходной картинки
        if (!$force_resize) {
            if (($fitwh == 'w' && $width == $w) || ($fitwh == 'h' && $height == $h) || ($fitwh != 'w' && $fitwh != 'h' && $width == $w && $height == $h)) {
                return $orig_image_url;
            }
        }

        // имя и путь к новой картинке (все в JPEG)
        $new_filename = md5($full_path . filesize($full_path)) . '.jpg';
        $new_folder_p1 = $width . 'x' . $height;
        if (!$crop && $fitwh == 'w')
            $new_folder_p1 = $width;
        if (!$crop && $fitwh == 'h')
            $new_folder_p1 = $height;
        $new_folder_p1 .= '-q' . $this->_quality;
        if ($this->_bg['r'] != 255 || $this->_bg['g'] != 255 || $this->_bg['b'] != 255)
            $new_folder_p1 .= '-' . $this->_rgb2hex($this->_bg);
        if ($crop)
            $new_folder_p1 .= '-crop';
        if (!$crop && $fitwh == 'w')
            $new_folder_p1 .= '-fitw';
        if (!$crop && $fitwh == 'h')
            $new_folder_p1 .= '-fith';
        if (!$crop && $fitwh == 'p')
            $new_folder_p1 .= '-pl';
        $new_folder_p2 = substr($new_filename, 0, 2);
        $new_folder_url = $this->absUrlMinPhoto; // . '/' . $new_folder_p1 . '/' . $new_folder_p2;
        $new_folder_path = $this->_urlMinPhoto; // . DIRECTORY_SEPARATOR . $new_folder_p1 . DIRECTORY_SEPARATOR . $new_folder_p2;

        // создадим папку
        if (!is_dir($new_folder_path))
            if (!mkdir($new_folder_path, 0755, true))
                return 'не найден путь к новой картинке ' . $new_folder_path;

        // новая ссылка и абсолютный путь
        $this->_newImageUrl = $new_folder_url . '/' . $new_filename;
        $this->_newImagePath = $new_folder_path . DIRECTORY_SEPARATOR . $new_filename;

        // если файл уже есть
        if (is_file($this->_newImagePath))
            return $this->_newImageUrl;

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
            $this->_saveImage($width, $height, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h);

            // новый путь
            if (is_file($this->_newImagePath))
                return $this->_newImageUrl;
        }

        return full_path;
    }

    /**
     * Почистим путь к картинке
     */
    private function _clearImagePath() {
        $this->_origImageFull = trim(str_replace([
            '\\',
            '/'
        ], DIRECTORY_SEPARATOR, $this->_origImageFull), DIRECTORY_SEPARATOR);
    }

    /**
     * Зададим абсолютный путь к картинке
     *
     * @return string
     */
    private function _getFullPath() {
        return $this->_siteRoot . DIRECTORY_SEPARATOR . $this->_origImageFull;
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
    private function _saveImage($width, $height, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h) {
        // создание и копирование
        $new_im = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($new_im, $this->_bg['r'], $this->_bg['g'], $this->_bg['b']);
        imagefill($new_im, 0, 0, $bg_color);
        imagecopyresampled($new_im, $this->_im, $dst_x, $dst_y, $x, $y, $new_w, $new_h, $w, $h);

        // сохранение
        // все в JPEG
        imagejpeg($new_im, $this->_newImagePath, $this->_quality);

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