<?php

# KCAPTCHA PROJECT VERSION 1.2.6

# Automatic test to tell computers and humans apart

# Copyright by Kruglov Sergei, 2006, 2007, 2008
# www.captcha.ru, www.kruglov.ru

# System requirements: PHP 4.0.6+ w/ GD

# KCAPTCHA is a free software. You can freely use it for building own site or software.
# If you use this software as a part of own sofware, you must leave copyright notices intact or add KCAPTCHA copyright notices to own.
# As a default configuration, KCAPTCHA has a small credits text at bottom of CAPTCHA image.
# You can remove it, but I would be pleased if you left it. ;)

# See kcaptcha_config.php for customization
namespace Bundle\CaptchaBundle;

class Captcha {

    private $alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!

    # symbols used to draw CAPTCHA
    //$allowed_symbols = "0123456789"; #digits
    private $allowed_symbols = "23456789abcdeghkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)

    # folder with fonts
    private $fontsdir = 'Resources/Fonts';

    # CAPTCHA string length
    private $length = 5;

    # CAPTCHA image size (you do not need to change it, whis parameters is optimal)
    private $width = 120;
    private $height = 60;

    # symbol's vertical fluctuation amplitude divided by 2
    private $fluctuation_amplitude = 5;

    # increase safety by prevention of spaces between symbols
    private $no_spaces = true;

    # show credits
    private $show_credits = true; # set to false to remove credits line. Credits adds 12 pixels to image height
    private $credits = ''; # if empty, HTTP_HOST will be shown

    # CAPTCHA image colors (RGB, 0-255)
    //$foreground_color = array(0, 0, 0);
    //$background_color = array(220, 230, 255);
    private $foreground_color;
    private $background_color;

    # JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
    private $jpegQuality = 90;

    /**
     * @var string
     * captcha value
     */
    private $key;

    const keySessionName = 'cSesValue';

    private $fonts = array();

    public function __construct() {
        $this->setupFonts();
        $this->foreground_color = array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));
        $this->background_color = array(mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
    }


    private function setupFonts(){
        $fontsdir = realpath(dirname(__FILE__) . '/' . $this->fontsdir);
        if ($handle = opendir($fontsdir)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match('/\.png$/i', $file)) {
                    $this->fonts[] = $fontsdir . '/' . $file;
                }
            }
            closedir($handle);
        }
    }

    public function generateKey(){
        $key = '';
        while (true) {
            $key = '';
            for ($i = 0; $i < $this->length; $i++) {
                $key .= $this->allowed_symbols{mt_rand(0, strlen($this->allowed_symbols) - 1)};
            }
            if (!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $key)) break;
        }
        return $key;
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key='', $force=false){
        $sessionKey = '';
        if (isset($_SESSION[self::keySessionName])){
            $sessionKey = $_SESSION[self::keySessionName];
        }
        if ((empty($key) && empty($sessionKey)) || $force){
            $key = $this->generateKey();
            $_SESSION[self::keySessionName] = $key;
        } else $key = $sessionKey;
        $this->key = $key;
    }

    public function generateImage(){
        if (!$this->key) $this->setKey();
        do {
            $fontFile = $this->fonts[mt_rand(0, count($this->fonts) - 1)];
            $font = imagecreatefrompng($fontFile);
            imagealphablending($font, true);
            $fontFileWidth = imagesx($font);
            $fontFileHeight = imagesy($font) - 1;
            $fontMetrics = array();
            $symbol = 0;
            $readingSymbol = false;

            $alphabetLength = strlen($this->alphabet);
            // loading font
            for ($i = 0; $i < $fontFileWidth && $symbol < $alphabetLength; $i++) {
                $transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

                if (!$readingSymbol && !$transparent) {
                    $fontMetrics[$this->alphabet{$symbol}] = array('start' => $i);
                    $readingSymbol = true;
                    continue;
                }

                if ($readingSymbol && $transparent) {
                    $fontMetrics[$this->alphabet{$symbol}]['end'] = $i;
                    $readingSymbol = false;
                    $symbol++;
                    continue;
                }
            }

            $img = imagecreatetruecolor($this->width, $this->height);
            imagealphablending($img, true);
            $white = imagecolorallocate($img, 255, 255, 255);
            $black = imagecolorallocate($img, 0, 0, 0);

            imagefilledrectangle($img, 0, 0, $this->width - 1, $this->height - 1, $white);

            // draw text
            $x = 1;
            
            for ($i = 0; $i < $this->length; $i++) {
                $m = $fontMetrics[$this->key{$i}];

                $y = mt_rand(-$this->fluctuation_amplitude, $this->fluctuation_amplitude) + ($this->height - $fontFileHeight) / 2 + 2;

                if ($this->no_spaces) {
                    $shift = 0;
                    if ($i > 0) {
                        $shift = 10000;
                        for ($sy = 7; $sy < $fontFileHeight - 20; $sy += 1) {
                            for ($sx = $m['start'] - 1; $sx < $m['end']; $sx += 1) {
                                $rgb = imagecolorat($font, $sx, $sy);
                                $opacity = $rgb >> 24;
                                if ($opacity < 127) {
                                    $left = $sx - $m['start'] + $x;
                                    $py = $sy + $y;
                                    if ($py > $this->height) break;
                                    for ($px = min($left, $this->width - 1); $px > $left - 12 && $px >= 0; $px -= 1) {
                                        $color = imagecolorat($img, $px, $py) & 0xff;
                                        if ($color + $opacity < 190) {
                                            if ($shift > $left - $px) {
                                                $shift = $left - $px;
                                            }
                                            break;
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                        if ($shift == 10000) {
                            $shift = mt_rand(4, 6);
                        }

                    }
                } else {
                    $shift = 1;
                }
                imagecopy($img, $font, $x - $shift, $y, $m['start'], 1, $m['end'] - $m['start'], $fontFileHeight);
                $x += $m['end'] - $m['start'] - $shift;
            }
        } while ($x >= $this->width - 10); // while not fit in canvas
        $center = $x / 2;

        // credits. To remove, see configuration file
        $img2 = imagecreatetruecolor($this->width, $this->height + ($this->show_credits ? 12 : 0));
        $foreground = imagecolorallocate($img2, $this->foreground_color[0], $this->foreground_color[1], $this->foreground_color[2]);
        $background = imagecolorallocate($img2, $this->background_color[0], $this->background_color[1], $this->background_color[2]);
        imagefilledrectangle($img2, 0, 0, $this->width - 1, $this->height - 1, $background);
        imagefilledrectangle($img2, 0, $this->height, $this->width - 1, $this->height + 12, $foreground);
        $credits = empty($credits) ? $_SERVER['HTTP_HOST'] : $credits;
        imagestring($img2, 2, $this->width / 2 - imagefontwidth(2) * strlen($credits) / 2, $this->height - 2, $credits, $background);

        // periods
        $rand1 = mt_rand(750000, 1200000) / 10000000;
        $rand2 = mt_rand(750000, 1200000) / 10000000;
        $rand3 = mt_rand(750000, 1200000) / 10000000;
        $rand4 = mt_rand(750000, 1200000) / 10000000;
        // phases
        $rand5 = mt_rand(0, 31415926) / 10000000;
        $rand6 = mt_rand(0, 31415926) / 10000000;
        $rand7 = mt_rand(0, 31415926) / 10000000;
        $rand8 = mt_rand(0, 31415926) / 10000000;
        // amplitudes
        $rand9 = mt_rand(330, 420) / 110;
        $rand10 = mt_rand(330, 450) / 110;

        //wave distortion

        for ($x = 0; $x < $this->width; $x++) {
            for ($y = 0; $y < $this->height; $y++) {
                $sx = $x + (sin($x * $rand1 + $rand5) + sin($y * $rand3 + $rand6)) * $rand9 - $this->width / 2 + $center + 1;
                $sy = $y + (sin($x * $rand2 + $rand7) + sin($y * $rand4 + $rand8)) * $rand10;

                if ($sx < 0 || $sy < 0 || $sx >= $this->width - 1 || $sy >= $this->height - 1) {
                    continue;
                } else {
                    $color = imagecolorat($img, $sx, $sy) & 0xFF;
                    $color_x = imagecolorat($img, $sx + 1, $sy) & 0xFF;
                    $color_y = imagecolorat($img, $sx, $sy + 1) & 0xFF;
                    $color_xy = imagecolorat($img, $sx + 1, $sy + 1) & 0xFF;
                }

                if ($color == 255 && $color_x == 255 && $color_y == 255 && $color_xy == 255) {
                    continue;
                } else if ($color == 0 && $color_x == 0 && $color_y == 0 && $color_xy == 0) {
                    $newred = $this->foreground_color[0];
                    $newgreen = $this->foreground_color[1];
                    $newblue = $this->foreground_color[2];
                } else {
                    $frsx = $sx - floor($sx);
                    $frsy = $sy - floor($sy);
                    $frsx1 = 1 - $frsx;
                    $frsy1 = 1 - $frsy;

                    $newcolor = (
                            $color * $frsx1 * $frsy1 +
                                    $color_x * $frsx * $frsy1 +
                                    $color_y * $frsx1 * $frsy +
                                    $color_xy * $frsx * $frsy);

                    if ($newcolor > 255) $newcolor = 255;
                    $newcolor = $newcolor / 255;
                    $newcolor0 = 1 - $newcolor;

                    $newred = $newcolor0 * $this->foreground_color[0] + $newcolor * $this->background_color[0];
                    $newgreen = $newcolor0 * $this->foreground_color[1] + $newcolor * $this->background_color[1];
                    $newblue = $newcolor0 * $this->foreground_color[2] + $newcolor * $this->background_color[2];
                }

                imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newred, $newgreen, $newblue));
            }
        }
        return $img2;
    }

    // generates keystring and image
    function show() {
        $img2 = $this->generateImage();
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');

        if (function_exists("imagejpeg")) {
            header("Content-Type: image/jpeg");
            imagejpeg($img2, null, $this->jpegQuality);
        } else if (function_exists("imagegif")) {
            header("Content-Type: image/gif");
            imagegif($img2);
        } else if (function_exists("imagepng")) {
            header("Content-Type: image/x-png");
            imagepng($img2);
        }
        return $img2;
    }

    function render(){
        echo '<img src="/_captcha" />';
    }

}

?>