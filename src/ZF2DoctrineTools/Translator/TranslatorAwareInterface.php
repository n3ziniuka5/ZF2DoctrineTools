<?php
namespace ZF2DoctrineTools\Translator;

use Zend\Mvc\I18n\Translator;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 */

interface TranslatorAwareInterface
{
    public function setTranslator(Translator $translator);
}