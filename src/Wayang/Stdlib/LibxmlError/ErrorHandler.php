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
use Wayang\Exception\Spl\RuntimeException;

/**
 */
class ErrorHandler implements ErrorHandlerInterface
{
	/**
	 * @var ErrorExceptionInterface|null
	 */
	protected $error;

	/**
	 * @var array
	 */
	protected $stack = [];

	/**
	 * @var bool
	 */
	protected $isRegistered;

	/**
	 * @var int
	 */
	protected $lastErrorIndex;

	/**
	 * @var bool
	 */
	protected $lastErrorStatus;

	/**
	 */
	public function __construct(bool $register = true){
		if ($register) {
			$this->register();
		}
	}

	/**
	 * @return bool
	 */
	public function isError(): bool{
		return $this->error !== null;
	}

	/**
	 * @return ErrorExceptionInterface|null
	 */
	public function getError(): ?ErrorExceptionInterface{
		return $this->error;
	}

	/**
	 * @return array
	 */
	public function getStack(): array{
		return $this->stack;
	}

	/**
	 * @return bool
	 */
	public function isRegistered(): bool{
		return $this->isRegistered;
	}

	/**
	 * @return bool
	 */
	public function register(): bool{
		if ($this->isRegistered) {
			return false;
		}
		$this->lastErrorIndex = count(libxml_get_errors());
		$this->lastErrorStatus = libxml_use_internal_errors(true);
		$this->isRegistered = true;
		return true;
	}

	/**
	 * @return bool
	 */
	public function restore(): bool{
		if (!$this->isRegistered) {
			return false;
		}
		$errors = libxml_get_errors();
		libxml_use_internal_errors($this->lastErrorStatus);
		if ($errors) {
			$this->handleErrors($errors);
		}
		$this->isRegistered = false;
		return true;
	}

	/**
	 * @throws RuntimeException
	 * @return void
	 */
	protected function handleErrors(array $errors): void{
		$length = count($errors);
		if ($this->lastErrorIndex > $length) {
			throw new RuntimeException('Illegal state.');
		}
		for (; $this->lastErrorIndex < $length; ++$this->lastErrorIndex) {
			$this->handleError($errors[$this->lastErrorIndex]);
		}
	}

	/**
	 * @return void
	 */
	protected function handleError(libXMLError $error): void{
		$this->error = $this->stack[] = new ErrorException($error, $this->error);
	}
}