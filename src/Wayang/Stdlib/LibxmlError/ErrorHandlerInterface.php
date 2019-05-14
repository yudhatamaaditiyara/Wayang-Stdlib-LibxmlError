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

/**
 */
interface ErrorHandlerInterface
{
	/**
	 * @return bool
	 */
	public function isError(): bool;

	/**
	 * @return ErrorExceptionInterface|null
	 */
	public function getError(): ?ErrorExceptionInterface;

	/**
	 * @return array
	 */
	public function getStack(): array;

	/**
	 * @return bool
	 */
	public function isRegistered(): bool;

	/**
	 * @return bool
	 */
	public function register(): bool;
	
	/**
	 * @return bool
	 */
	public function restore(): bool;
}