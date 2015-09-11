<?php
/**
 * description
 *
 * Filename: MAutoloadPath.class.php
 *
 * @author liyan
 * @since 2015 9 11
 */
namespace Dojet;

class MAutoloadPath {

    protected $autoloadPaths = array();

    public function addAutoloadPath($autoloadPath) {
        $key = md5($autoloadPath);
        $this->autoloadPaths[$key] = $autoloadPath;
    }

    public function addAutoloadPathArray($arrAutoloadPath) {
        foreach ($arrAutoloadPath as $autoloadPath) {
            $this->addAutoloadPath($autoloadPath);
        }
    }

    public function autoloadPaths() {
        return $this->autoloadPaths;
    }

}
