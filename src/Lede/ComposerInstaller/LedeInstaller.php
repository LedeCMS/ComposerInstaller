<?php

namespace Lede\ComposerInstaller;


use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class LedeInstaller extends LibraryInstaller
{

    protected $locations
        = [
            'core-module' => 'LedeCMS/Modules/',
            'core-theme'  => 'LedeCMS/Themes/',
            'module'      => 'Modules/',
            'theme'       => 'Themes/',
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

        $typeName = str_replace('ledecms/', '', $package->getType());
        if ($typeName === 'theme' || $typeName === 'core-theme') {
            $name = preg_replace('/-module$/', '', $name);
        } else {
            $name = preg_replace('/-theme$/', '', $name);
        }
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
            if ($packageType === 'ledecms/'.$type) {
                return true;
            }
        }
        return false;
    }
}