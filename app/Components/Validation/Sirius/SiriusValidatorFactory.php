<?php namespace App\Components\Validation\Sirius;

use App\Components\Validation\FactoryInterface;
use Sirius\Validation\Validator;

/**
 * A Sirius Validator factory
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */
class SiriusValidatorFactory implements FactoryInterface
{

    /**
     * @param array $formData
     * @param array $rules
     * @param array $messages
     *
     * @return \App\Components\Validation\ValidatorInterface
     */
    public function make(array $formData, array $rules, array $messages = array())
    {
        $validator = new Validator;

        foreach($rules as $field => $rules) {

            if(!is_array($rules)) {
                $rules = array($rules => null);
            }

            foreach($rules as $key => $value) {

                if(is_string($key)) { // real rule name
                    $rule = $key;
                    $options = $value;
                }
                else { // otherwise the key is not the rule name, but the value is. No options specified
                    $rule = $value;
                    $options = null;
                }

                $ruleMessages = isset($messages[$field]) && isset($messages[$field][$rule]) ?
                    $messages[$field][$rule] : null;

                $validator->add($field, $rule, $options, $ruleMessages);
            }
        }

        $validator->validate($formData);
        return new SiriusValidatorAdapter($validator);
    }
}
