<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCache extends Command
{
	protected function configure(){
		$this->setName('app:clear-cache')
			->setDescription("Clear the template cache.");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->deleteDirectoryContent(CACHE);

		$output->writeln("<info>The cache has been cleaned.</info>");
	}

	private function deleteDirectoryContent($dirname, $removeFolder = false) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);

		if (!$dir_handle) return false;

		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file)) {
					unlink($dirname."/".$file);
				}
				else {
					$this->deleteDirectoryContent($dirname.'/'.$file, true);
				}
			}
		}
		closedir($dir_handle);

		if(true === $removeFolder) {
			rmdir($dirname);
		}
		return true;
	}
}