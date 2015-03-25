<?php namespace App\Components\Validation;

/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Jeffrey Way <jeffrey@laracasts.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Form validation base class. Extend and set rules as well as messages as
 * required.
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */
abstract class FormValidator
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var ValidatorInterface
     */
    protected $validation;

    /**
     * @var array
     */
    protected $messages = array();

    /**
     * Validation rules defined in an associative array
     *
     * '#fieldname#' => array('#rulename#' => '#options as string#'|null, ...)
     *
     * @var array
     */
    protected $rules = array();

    /**
     * @param FactoryInterface $factory
     */
    function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Validate the form data
     *
     * @throws FormValidationException
     *         whenever the validation fails
     *
     * @param mixed $formData
     *
     * @return bool
     */
    public function validate($formData)
    {
        $formData = $this->normalizeFormData($formData);

        $this->validation = $this->factory->make(
            $formData,
            $this->getValidationRules(),
            $this->getValidationMessages()
        );

        if ($this->validation->fails())
        {
            throw new FormValidationException('Validation failed', $this->getValidationErrors());
        }

        return true;
    }

    /**
     * @return array
     */
    public function getValidationRules()
    {
        return $this->rules;
    }

    /**
     * @return mixed
     */
    public function getValidationErrors()
    {
        return $this->validation->errors();
    }

    /**
     * @return array
     */
    public function getValidationMessages()
    {
        return $this->messages;
    }

    /**
     * Normalize the provided data to an array.
     *
     * @param mixed $formData
     * @return array
     */
    protected function normalizeFormData($formData)
    {
        // If an object was provided, maybe the user
        // is giving us something like a DTO.
        // In that case, we'll grab the public properties
        // off of it, and use that.
        if (is_object($formData)) {
            return get_object_vars($formData);
        }

        // Otherwise, we'll just stick with what they provided.
        return $formData;
    }
}