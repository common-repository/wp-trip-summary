<?php
/**
 * Copyright (c) 2014-2024 Alexandru Boia and Contributors
 *
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 *	1. Redistributions of source code must retain the above copyright notice, 
 *		this list of conditions and the following disclaimer.
 *
 * 	2. Redistributions in binary form must reproduce the above copyright notice, 
 *		this list of conditions and the following disclaimer in the documentation 
 *		and/or other materials provided with the distribution.
 *
 *	3. Neither the name of the copyright holder nor the names of its contributors 
 *		may be used to endorse or promote products derived from this software without 
 *		specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, 
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY 
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES 
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) 
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 */

if (!defined('ABP01_LOADED') || !ABP01_LOADED) {
	exit;
}

class Abp01_Installer_Step_Update_UpdateTo022 implements Abp01_Installer_Step_Update_Interface {

	/**
	 * @var Abp01_Env
	 */
	private $_env;

	public function __construct(Abp01_Env $env) {
		$this->_env = $env;
	}

	public function execute() { 
		return $this->_ensureStorageDirectories() 
			&& $this->_installStorageDirsSecurityAssets()
			&& $this->_createCapabilities();
	}

	private function _ensureStorageDirectories() {
		$rootStorageDir = $this->_env->getRootStorageDir();
		$tracksStorageDir = $this->_env->getTracksStorageDir();
		$cacheStorageDir = $this->_env->getCacheStorageDir();
		$logStorageDir = $this->_env->getLogStorageDir();

		$service = new Abp01_Installer_Service_CreateStorageDirectories($rootStorageDir, 
			$tracksStorageDir, 
			$cacheStorageDir,
			$logStorageDir);

		return $service->execute();
	}

	private function _installStorageDirsSecurityAssets() {
		$rootStorageDir = $this->_env->getRootStorageDir();
		$tracksStorageDir = $this->_env->getTracksStorageDir();
		$cacheStorageDir = $this->_env->getCacheStorageDir();
		$logStorageDir = $this->_env->getLogStorageDir();

		$service = new Abp01_Installer_Service_CreateStorageDirsSecurityAssets($rootStorageDir, 
			$tracksStorageDir, 
			$cacheStorageDir,
			$logStorageDir);

		return $service->execute();
	}

	private function _createCapabilities() {
		$service = new Abp01_Installer_Service_CreateCapabilities();
		return $service->execute();
	}

	public function getLastError() { 
		return null;
	}

	public function getTargetVersion() {
		return '0.2.2';
	}
}