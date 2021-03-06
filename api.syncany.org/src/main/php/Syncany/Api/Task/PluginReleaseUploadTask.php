<?php

/*
 * Syncany, www.syncany.org
 * Copyright (C) 2011-2015 Philipp C. Heckel <philipp.heckel@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Syncany\Api\Task;

use Syncany\Api\Config\Config;
use Syncany\Api\Exception\Http\BadRequestHttpException;
use Syncany\Api\Exception\Http\ServerErrorHttpException;
use Syncany\Api\Model\FileHandle;
use Syncany\Api\Model\TempFile;
use Syncany\Api\Util\FileUtil;
use Syncany\Api\Util\StringUtil;

abstract class PluginReleaseUploadTask extends ReleaseUploadTask
{
	protected $pathPluginDist;
	protected $pluginId;

	public function __construct(FileHandle $fileHandle, $fileName, $checksum, $snapshot, $os, $arch, $pluginId)
	{
		parent::__construct($fileHandle, $fileName, $checksum, $snapshot, $os, $arch);

		$this->pathPluginDist = Config::get("paths.dist.plugins");
		$this->pluginId = $pluginId;
	}

	protected function getTargetFile()
	{
		$pluginTargetSubFolder = ($this->snapshot) ? "snapshots" : "releases";
		$pluginTargetFolder = $this->pathPluginDist . "/" . $pluginTargetSubFolder . "/" . $this->pluginId;

		return $pluginTargetFolder . "/" . basename($this->fileName);
	}
}
