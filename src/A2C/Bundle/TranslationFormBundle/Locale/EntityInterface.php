<?php
/**
 * Created by PhpStorm.
 * User: adan
 * Date: 09/11/15
 * Time: 19:29
 */

namespace A2C\Bundle\TranslationFormBundle\Locale;


interface EntityInterface
{
    public function getAcron();

    public function getLocale();
}