<?php

class Wizard
{
    const MIN_ICON_NB = 0;
    const DEFAULT_ICON_NB = 3;
    const MAX_ICON_NB = 10;
    const MIN_ROW_NB = 0;
    const DEFAULT_ROW_NB = 3;
    const MAX_ROW_NB = 10;

    protected $iconDirs;

    public function __construct()
    {
        $this->iconDirs = array();
    }

    /**
     * Add an array of icon directories
     * @param mixed $iconDirs
     * @return false|mixed
     */
    public function addIconDir($iconDirs)
    {
        if (!is_array($iconDirs) or empty($iconDirs)) {
            throw new Exception("Need an array of dirs.");
        }

        $this->iconDirs = array_merge($this->iconDirs, $iconDirs);

        return $this;
    }

    /**
     * Choose randomly $iconNb icons, $rowNb times
     * @param  integer $iconNb Nb of icons to display
     * @param  integer $rowNb  Nb of lines of icons to display
     * @return array Lines of icons paths
     */
    public function play($iconNb=3, $rowNb=3)
    {
        if ($iconNb <= self::MIN_ICON_NB or $iconNb >= self::MAX_ICON_NB) {
            $iconNb = self::DEFAULT_ICON_NB;
        }

        if ($rowNb <= self::MIN_ROW_NB or $rowNb >= self::MAX_ROW_NB) {
            $rowNb = self::DEFAULT_ROW_NB;
        }

        $iconsList = array();

        // get a list of all possible icons
        $allIconsList = $this->getAllIconsList();
        $allIconsNb = count($allIconsList);

        for($i=1 ; $i <= $rowNb ; $i++) {
            $iconsLine = array();

            for($j=1 ; $j <= $iconNb ; $j++) {
                // get $iconNb random icons in the list
                $index = rand(0, $allIconsNb-1);
                $iconPath = $allIconsList[$index];

                // add this icon in the result list
                array_push($iconsLine, $iconPath);

                // suppress the choosen icon from the list
                unset($allIconsList[$index]);
            }

            array_push($iconsList, $iconsLine);
        }

        // return the result list
        return $iconsList;
    }

    /**
     * Returns a array of all icons path
     * @return array
     */
    protected function getAllIconsList()
    {
        $allIconsList = array();

        foreach($this->iconDirs as $iconDir) {
            // TODO: verify dirs

            // glob(*.svg)
            $files = glob(SYS_ICONS . $iconDir . '/*.svg');

            // add in $allIconsList
            $allIconsList = array_merge($allIconsList, $files);
        }

        return $allIconsList;
    }
}
