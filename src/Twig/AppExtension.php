<?php

    namespace App\Twig;

    use App\Service\GlobalDataService;
    use Twig\Extension\AbstractExtension;
    use Twig\Extension\GlobalsInterface;

    class AppExtension extends AbstractExtension implements GlobalsInterface
    {
        private GlobalDataService $globalData;

        public function __construct(GlobalDataService $globalData)
        {
            $this->globalData = $globalData;
        }

        public function getGlobals(): array
        {
            return $this->globalData->getGlobalData();
        }
    }
