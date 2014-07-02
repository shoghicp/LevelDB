<?php

/*
 * LevelDB pure-PHP library
 * Copyright (C) 2014 PocketMine Team <https://github.com/PocketMine/LevelDB>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

namespace leveldb;

class LevelDB{

	const NO_COMPRESSION = 0x00;
	const SNAPPY_COMPRESSION = 0x01;
	const DEFLATE_COMPRESSION = 0x02; //TODO: check the identifier

	/** @var mixed[] */
	protected $options = [];
	/** @var mixed[] */
	protected $readOptions = [];
	/** @var mixed[] */
	protected $writeOptions = [];

	protected $path;


	/**
	 * Instantiates a LevelDB object and opens the give database.
	 *
	 * @param string $name Corresponds to a file system directory where the database is stored
	 * @param array $options
	 * @param array $readOptions
	 * @param array $writeOptions
	 */
	public function __construct($name, $options = [], $readOptions = [], $writeOptions = []){
		$defaultOptions = [
			'create_if_missing' => true, //if the specified database didn't exist will create a new one
			'error_if_exists' => false, //if the opened database exists will throw exception
			'paranoid_checks' => false,
			'block_cache_size' => 8 * (2 << 20),
			'write_buffer_size' => 4 << 20,
			'block_size' => 4096,
			'max_open_files' => 1000,
			'block_restart_interval' => 16,
			'compression' => self::SNAPPY_COMPRESSION,
			'comparator' => null, //any callable parameter return 0, -1, 1
		];
		$defaultReadOptions = [
			'verify_check_sum' => false,
			'fill_cache' => true,
		];
		$defaultWriteOptions = [
			'sync' => false
		];

		foreach($options as $key => $value){
			$defaultOptions[$key] = $value;
		}

		foreach($readOptions as $key => $value){
			$defaultReadOptions[$key] = $value;
		}

		foreach($writeOptions as $key => $value){
			$defaultWriteOptions[$key] = $value;
		}

		$this->options = $defaultOptions;
		$this->readOptions = $defaultReadOptions;
		$this->writeOptions = $defaultWriteOptions;
	}

	protected function getOption($name){
		try{
			return $this->options[$name];
		}catch(\ErrorException $e){
			return null;
		}
	}
}