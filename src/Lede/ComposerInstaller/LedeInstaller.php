<?php

namespace Lede\ComposerInstaller;


use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class LedeInstaller extends LibraryInstaller
{

    protected $locations
        = [
            'core' => 'LedeCMF/Core/',
            'extra'  => 'LedeCMF/Extra/',
        ];

    public function getInstallPath(PackageInterface $package)
    {
        $prettyName = $package->getPrettyName();
        if (strpos($prettyName, '/') !== false) {
            list($vendor, $name) = explode('/', $prettyName);
        } else {
            $vendor = '';
            $name   = $prettyName;
        }

        $typeName = str_replace('ledecmf-', '', $package->getType());
        $name = str_replace(['-', '_'], ' ', $name);
        $name = str_replace(' ', '', ucwords($name));

        return $this->locations[$typeName].$name.'/';
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {

        foreach (array_keys($this->locations) as $type) {
            if ($packageType === 'ledecms-'.$type) {

                return true;
            }
        }
        return false;
    }
}
