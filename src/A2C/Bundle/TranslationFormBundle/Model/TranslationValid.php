<?php

namespace A2C\Bundle\TranslationFormBundle\Model;

/**
 * Class TranslationValid
 * @package A2C\Bundle\TranslationFormBundle\Model
 *
 * @author Adan Felipe Medeiros
 * @version 1.0
 */
trait TranslationValid
{
    /**
     * @param array $fieldClass
     * @param array $fieldTranlate
     * @return array
     */
    protected function excludeFunctionsTranslate($fieldClass,$fieldTranlate)
    {
        $arrayValid = array_diff($fieldClass,$fieldTranlate);
        $arrayValid[] = 'getId';
        return $this->getAllField($arrayValid);
    }

    /**
     * @param array $fields
     * @return array
     */
    protected function getAllField($fields)
    {
        $arrayValid = array_filter($fields, function($element) {
            if (preg_match('/^set/',$element) == 0) {
                return $element;
            }
        });

        unset($arrayValid[array_keys($arrayValid,'excludeFunctionsTranslate')[0]]);
        unset($arrayValid[array_keys($arrayValid,'isSave')[0]]);
        unset($arrayValid[array_keys($arrayValid,'getAllField')[0]]);

        return $arrayValid;
    }

    /**
     * @return bool
     */
    public function isSave()
    {
        $field = get_class_methods($this);
        $fieldTranslate = get_class_methods('Knp\DoctrineBehaviors\Model\Translatable\Translation');

        $fieldsValid = $this->excludeFunctionsTranslate($field,$fieldTranslate);

        $isSave = false;

        foreach ($fieldsValid as $fields) {

            if ( !is_null($this->{$fields}())) {

                if (is_bool($this->{$fields}())){
                    if ( $this->{$fields}() ) {
                        $isSave = true;
                        break;
                    }
                } else {
                    $isSave = true;
                    break;
                }
            }
        }

        return $isSave;
    }
}