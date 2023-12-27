<?php

namespace JambageCom\Div2007\Api;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
/**
 * Part of the div2007 (Static Methods for Extensions since 2007) extension.
 *
 * Control functions
 *
 * @author  Franz Holzinger <franz@ttproducts.de>
 *
 * @maintainer	Franz Holzinger <franz@ttproducts.de>
 *
 * @package TYPO3
 * @subpackage div2007
 */
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Routing\RouteNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class OldFrontendApi
{
    /**
     * This method is needed only for Ajax calls.
     * You can use $GLOBALS['TSFE']->id or $GLOBALS['TSFE']->determineId instead of this method.
     *
     * @return int
     */
    public static function getPageId(...$params)
    {
        $result = (int)GeneralUtility::_GP('id');
        if (
            $result
        ) {
            return $result;
        }

        $request = null;
        $site = null;
        $result = 0;

        if (
            isset($params['0']) &&
            $params['0'] instanceof ServerRequestInterface
        ) {
            $request = $params['0'];
        }

        if (
            $request === null &&
            is_object($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][DIV2007_EXT]['TYPO3_REQUEST'])
        ) {
            $request = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][DIV2007_EXT]['TYPO3_REQUEST'];
        }

        if ($request instanceof ServerRequestInterface) {
            $matcher = GeneralUtility::makeInstance(
                SiteMatcher::class,
                GeneralUtility::makeInstance(SiteFinder::class)
            );
            /** @var SiteRouteResult $routeResult */
            $routeResult = $matcher->matchRequest($request);
            /** @var Site $site */
            $site = $routeResult->getSite();
        }

        if (
            isset($site) &&
            $site instanceof Site
        ) {
            try {
                $previousResult = $request->getAttribute('routing', null);
                if (method_exists($previousResult, 'getPageId')) {
                    $result = $previousResult->getPageId();
                }
                // Check for the route
                if (!$result) {
                    $pageArguments = $site->getRouter()->matchRequest($request, $previousResult);
                    $result = $pageArguments->getPageId();
                }
            } catch (RouteNotFoundException $e) {
                return GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction(
                    $request,
                    'The requested page does not exist',
                    ['code' => PageAccessFailureReasons::PAGE_NOT_FOUND]
                );
            }
        }

        return $result;
    }
}
