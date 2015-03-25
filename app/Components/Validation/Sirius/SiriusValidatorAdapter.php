<?php namespace App\Components\Validation\Sirius;

use App\Components\Validation\ValidatorInterface;
use Sirius\Validation\Validator;

/**
 * Adapter class for implementing the ValidatorInterface using the Sirius
 * validation library.
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */
class SiriusValidatorAdapter implements ValidatorInterface
{
    /**
     * @var \Sirius\Validation\Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function fails()
    {
        return $this->validator->getMessages() ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function errors()
    {
        return $this->validator->getMessages();
    }
}