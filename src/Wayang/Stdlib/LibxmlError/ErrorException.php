<?php
/**
 * Copyright (C) 2019 Yudha Tama Aditiyara
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Wayang\Stdlib\LibxmlError;

use libXMLError;
use Wayang;

/**
 */
class ErrorException extends Wayang\Exception\ErrorException implements ErrorExceptionInterface
{
	/**
	 * @var int
	 */
	protected $column;

	/**
	 * @var libXMLError
	 */
	protected $error;

	/**
	 * @param libXMLError $error
	 * @param ErrorExceptionInterface|null $previous
	 */
	public function __construct(libXMLError $error, ErrorExceptionInterface $previous = null){
		parent::__construct($error->message, $error->code, $error->level, $error->file, $error->line, $previous);
		$this->column = $error->column;
		$this->error = $error;
	}

	/**
	 * @return int
	 */
	public function getColumn(): int{
		return $this->column;
	}

	/**
	 * @return libXMLError
	 */
	public function getError(): libXMLError{
		return $this->error;
	}
}