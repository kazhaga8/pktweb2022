<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Str;

function acakCaptcha()
{
    $kode = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $pass = array();

    $panjangkode = strlen($kode) - 2;
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangkode);
        $pass[] = $kode[$n];
    }
    return implode($pass);
}
function reCaptcha()
{
    $code = acakCaptcha();
    session(['captcha_code' => $code]);
    $gbr = imagecreate(257, 50);

    imagecolorallocate($gbr, 244, 121, 32);

    $color = imagecolorallocate($gbr, 253, 252, 252);
    putenv('GDFONTPATH=' . realpath('.'));
    $font = public_path('assets/fonts/ArialTh.ttf');
    $ukuran_font = 20;
    $posisi = 35;
    $stringLength = strlen($code);
    for ($i = 0; $i < $stringLength; $i++) {
        $kemiringan = rand(1, 20);

        imagettftext($gbr, $ukuran_font, $kemiringan, 60 + 30 * $i, $posisi, $color, $font, $code[$i]);
    }
    ob_start();
    header("Content-Type: image/jpeg");
    ImageJpeg($gbr);
    $img = ob_get_clean();

    ImageDestroy($gbr);
    return base64_encode($img);
}
function setSectionAnchor($source, $anchor)
{
    preg_match_all("'<section(.*?)>'si", $source, $pages);
    if (count($pages[0]) > 0) {
        preg_match_all("'id=\"(.*?)\"'si", $pages[0][0], $section);
        $source = str_replace('id="' . $section[1][0] . '"', 'id="' . $anchor . '"', $source);
    }
    return $source;
}
function renderPage($page, $locale)
{
    $content = $page->content;
    preg_match_all("'&lt;!--MODULE-(.*?)--&gt;(.*?)&lt;!--/MODULE-(.*?)--&gt;'si", $content, $module);
    if (count($module[0]) > 0) {
        if ($module[1][0] == "HOME-INVESTOR") {
            $replace_content = WebController::rederHomeInvestors();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "HOME-NEWS") {
            $replace_content = WebController::rederHomeNews();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "PROFILE-TIMELINE") {
            $replace_content = WebController::rederProfileTimelines($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "DEWAN-KOMISARIS") {
            $replace_content = WebController::rederDewanKomisaris($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "DIREKSI") {
            $replace_content = WebController::rederDireksi($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "SEKPER") {
            $replace_content = WebController::rederSekper($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "AWARD") {
            $replace_content = WebController::rederAward($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "LAPORAN-KEBERLANJUTAN") {
            $replace_content = WebController::rederKeberlanjutan($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "LAPORAN-TAHUNAN") {
            $replace_content = WebController::rederTahunan($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "LAPORAN-KEUANGAN") {
            $replace_content = WebController::rederKeuangan($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "CONTACT") {
            $replace_content = WebController::rederContact($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "NEWS") {
            $replace_content = WebController::rederNews($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "GALLERY") {
            $replace_content = WebController::rederGallery($locale);
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
    }

    preg_match_all("'&lt;div class=&quot;bg-(.*?)&quot;&gt;'si", $content, $element);
    if (count($element[0]) > 0) {
        if (preg_match('/(' . $element[1][0] . ')/', 'product|profil-bisnis|greenport|amoniak') && $page->image !== '') {
            $bgstyle = "&lt;div class=&quot;bg-" . $element[1][0] . "&quot; style=&quot;background-image: url(&#039;" . url('public') . $page->image . "&#039;);&quot;&gt;";
            $content    = str_replace($element[0][0], $bgstyle, $content);
        }
    }
    preg_match_all("'&lt;section(.*?)class=&quot;(.*?)&quot;&gt;'si", $content, $element);
    if (count($element[0]) > 0) {
        if (preg_match('/(' . $element[2][0] . ')/', 'investor|profil-bisnis|greenport') && $page->image !== '') {
            $elm = str_replace('&gt;', '', $element[0][0]);
            $bgstyle = $elm . " style=&quot;background: url(&#039;" . url('public') . $page->image . "&#039;) fixed center center;background-size: cover;background-position: 0 0px;&quot;&gt;";
            $content    = str_replace($element[0][0], $bgstyle, $content);
        }
    }
    $content = html_entity_decode($content);
    $content = str_replace('../../public', url('public'), $content);

    return $content;
}
