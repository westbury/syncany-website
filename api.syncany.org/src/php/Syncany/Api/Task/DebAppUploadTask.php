<?php

namespace Syncany\Api\Task;

use Syncany\Api\Model\TempFile;
use Syncany\Api\Util\FileUtil;
use Syncany\Api\Util\RepreproUtil;
use Syncany\Api\Util\StringUtil;

class DebAppUploadTask extends AppUploadTask
{
	public function execute()
	{
		$tempDirContext = "app/deb";

		$tempDir = FileUtil::createTempDir($tempDirContext);
		$tempFile = FileUtil::writeToTempFile($this->fileHandle, $tempDir, ".deb");

		$this->validateChecksum($tempFile);
		$this->addToAptArchive($tempFile);

		$targetFile = $this->moveFile($tempFile);
		$this->createLatestLink($targetFile);

		FileUtil::deleteTempDir($tempDir);
	}

	private function addToAptArchive(TempFile $debFile)
	{
		$codename = ($this->snapshot) ? "snapshot" : "release";
		RepreproUtil::includeDeb($codename, $debFile);
	}

	protected function getLatestLinkBasename()
	{
		$snapshotSuffix = ($this->snapshot) ? "-snapshot" : "";

		return StringUtil::replace("syncany-latest{snapshot}.deb", array(
			"snapshot" => $snapshotSuffix
		));
	}
}