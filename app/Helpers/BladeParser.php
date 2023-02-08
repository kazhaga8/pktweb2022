<?php

use App\Http\Controllers\WebController;

function setSectionAnchor($source, $anchor)
{
    preg_match_all("'<section(.*?)>'si", $source, $pages);
    if (count($pages[0]) > 0) {
        preg_match_all("'id=\"(.*?)\"'si", $pages[0][0], $section);
        $source = str_replace('id="' . $section[1][0] . '"', 'id="' . $anchor . '"', $source);
    }
    return $source;
}
function renderPage($page)
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
            $replace_content = WebController::rederProfileTimelines();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "DEWAN-KOMISARIS") {
            $replace_content = WebController::rederDewanKomisaris();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "DIREKSI") {
            $replace_content = WebController::rederDireksi();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "SEKPER") {
            $replace_content = WebController::rederSekper();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "AWARD") {
            $replace_content = WebController::rederAward();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "LAPORAN-KEBERLANJUTAN") {
            $replace_content = WebController::rederKeberlanjutan();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "LAPORAN-TAHUNAN") {
            $replace_content = WebController::rederTahunan();
            $content    = str_replace($module[0][0], $replace_content, $content);
        }
        if ($module[1][0] == "LAPORAN-KEUANGAN") {
            $replace_content = WebController::rederKeuangan();
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
