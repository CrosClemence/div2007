<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2018 Franz Holzinger (franz@ttproducts.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * adapter for the call of TYPO3 core functions
 * It takes care of the differences between the TYPO3 versions 4.5 and 6.2.
 * See the TYPO3 core files for the descriptions of these functions.
 *
 *
 * @package    TYPO3
 * @subpackage div2007
 * @author	Franz Holzinger <franz@ttproducts.de>
 */

 // deprecated: will be removed in 2024


class tx_div2007_core {
	/**
	 * Fields that are considered as system.
	 *
	 * @var array
	 */
	static protected $systemFields = array(
		'uid',
		'pid',
		'tstamp',
		'crdate',
		'deleted',
		'hidden',
		'starttime',
		'endtime',
		'sys_language_uid',
		'l18n_parent',
		'l18n_diffsource',
		't3ver_oid',
		't3ver_wsid',
		't3ver_state',
		't3ver_stage',
		't3ver_count',
		't3ver_tstamp',
		't3_origuid',
	);

    /**
    * Returns an integer format of the current three part version number, eg '4.12.3' -> 4012003
    * return
    *  int Integer version of version number (where each part can count to 999)
    **/
	static public function getTypoVersion () {
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\VersionNumberUtility';
		if (
			class_exists($callingClassName) &&
			method_exists($callingClassName, 'convertVersionNumberToInteger')
		) {
			$useClassName = substr($callingClassName, 1);
			$result = call_user_func($useClassName . '::convertVersionNumberToInteger', TYPO3_version);
		}
		return $result;
	}


	### Mathematical functions
	static public function testInt ($var) {
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\MathUtility';

		if (
			class_exists($callingClassName) &&
			method_exists($callingClassName, 'canBeInterpretedAsInteger')
		) {
			$useClassName = substr($callingClassName, 1);
			$result = call_user_func($useClassName . '::canBeInterpretedAsInteger', $var);
		}

		return $result;
	}

	static public function intInRange ($theInt, $min, $max = 2000000000, $zeroValue = 0) {
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\MathUtility';

		if (
			class_exists($callingClassName) &&
			method_exists($callingClassName, 'forceIntegerInRange')
		) {
			$useClassName = substr($callingClassName, 1);
			$result = call_user_func($useClassName . '::forceIntegerInRange', $theInt, $min, $max, $zeroValue);
		}
		return $result;
	}

	static public function intval_positive ($theInt) {
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\MathUtility';

		if (
			class_exists($callingClassName) &&
			method_exists($callingClassName, 'convertToPositiveInteger')
		) {
			$useClassName = substr($callingClassName, 1);
			$result = call_user_func($useClassName . '::convertToPositiveInteger', $theInt);
		}

		return $result;
	}


	### HTML parser object
	### attention: some methods have been moved into the classs \TYPO3\CMS\Core\Service\MarkerBasedTemplateService . Use the $html parameter for the methods which type you will use.

	static public function newHtmlParser ($html = true) {
        $useClassName = '';

        $checkClassName = '\\TYPO3\\CMS\\Core\\Service\\MarkerBasedTemplateService';
        if (class_exists($checkClassName)) {
            $callingClassName = $checkClassName;
        }

        if (
            class_exists($callingClassName)
        ) {
			$useClassName = substr($callingClassName, 1);

            $callingClassName2 = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
            $useClassName2 = substr($callingClassName2, 1);
            $result = call_user_func($useClassName2 . '::makeInstance', $useClassName);
		}

		return $result;
	}


	### TS parser object
	static public function newTsParser () {
		$useClassName = '';
		$callingClassName = '\\TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser';

		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);

            $callingClassName2 = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
            $useClassName2 = substr($callingClassName2, 1);
            $result = call_user_func($useClassName2 . '::makeInstance', $useClassName);
        }

		return $result;
	}


	### Mail object
	static public function newMailMessage () {

		$useClassName = '';
		$callingClassName = '\\TYPO3\\CMS\\Core\\Mail\\MailMessage';

		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);

            $callingClassName2 = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
            $useClassName2 = substr($callingClassName2, 1);
            $result = call_user_func($useClassName2 . '::makeInstance', $useClassName);
        }

		return $result;
	}


	### Caching Framework
	static public function initializeCachingFramework () {
		$useClassName = '';
		$callingClassName = '\\TYPO3\\CMS\\Core\\Cache\\Cache';

		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);
		}

		if (method_exists($useClassName, 'initializeCachingFramework')) {

			call_user_func($useClassName . '::initializeCachingFramework');
		}
	}


	### Debug Utility
	static public function debug ($var = '', $header = '', $group = 'Debug') {
		$callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\DebugUtility';

		if (
			class_exists($callingClassName) &&
			method_exists($callingClassName, 'debug')
		) {
            $useClassName = substr($callingClassName, 1);
			call_user_func($useClassName . '::debug', $var, $header, $group);
		}
	}

	static public function debugTrail () {
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\DebugUtility';

		if (
			class_exists($callingClassName) &&
			method_exists($callingClassName, 'debugTrail')
		) {
            $useClassName = substr($callingClassName, 1);
			$result = call_user_func($useClassName . '::debugTrail');
		}

		return $result;
	}


	### BACKEND

	### Backend Utility
	static public function getTCAtypes ($table, $rec, $useFieldNameAsKey = 0) {
		$useClassName = '';
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Backend\\Utility\\BackendUtility';

		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);
		}

		if (method_exists($useClassName, 'getTCAtypes')) {

			$result = call_user_func($useClassName . '::getTCAtypes', $table, $rec, $useFieldNameAsKey);
		}

		return $result;
	}

	static public function getRecord ($table, $uid, $fields = '*', $where = '', $useDeleteClause = TRUE) {
		$useClassName = '';
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Backend\\Utility\\BackendUtility';

		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);
		}

		if (method_exists($useClassName, 'getRecord')) {

			$result = call_user_func($useClassName . '::getRecord', $table, $uid, $fields, $where, $useDeleteClause);
		}

		return $result;
	}

    static public function deleteClause ($table, $tableAlias = '') {
		$result = FALSE;
		if ($tableAlias == '') {
            $tableAlias = $table;
        }
        if (!strcmp($table, 'pages')) { // Hardcode for pages because TCA might not be loaded yet (early frontend initialization)
            $result = ' AND ' . $tableAlias . '.deleted=0';
        } else {
            $result = $GLOBALS['TCA'][$table]['ctrl']['delete'] ? ' AND ' . $tableAlias . '.' . $GLOBALS['TCA'][$table]['ctrl']['delete'] . '=0' : '';
        }
		return $result;
    }

	static public function getTCEFORM_TSconfig ($table, $row) {
		$useClassName = '';
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Backend\\Utility\\BackendUtility';

		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);
		}

		if (method_exists($useClassName, 'getTCEFORM_TSconfig')) {

			$result = call_user_func($useClassName . '::getTCEFORM_TSconfig', $table, $row);
		}

		return $result;
	}


	### TYPO3 SPECIFIC FUNCTIONS

	static public function calculateCacheHash (array $params) {
		$useClassName = '';
		$result = FALSE;
		$callingClassName = '\\TYPO3\\CMS\\Frontend\\Page\\CacheHashCalculator';
		if (
			class_exists($callingClassName)
		) {
			$useClassName = substr($callingClassName, 1);
            $callingClassName2 = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
            $useClassName2 = substr($callingClassName2, 1);
            $cacheHash = call_user_func($useClassName2 . '::makeInstance', $useClassName);
			$result = $cacheHash->calculateCacheHash($params);
		}

		return $result;
	}

	/**
	* generates a hash value out of a string array.
	*
	* Checks the configuration and substitutes defaults for missing values.
	*
	* @param array $params parameter strings
	* @return bool/string hash string if initialization was successful, FALSE otherwise
	* @see tx_myext_class:anotherFunc()
	*/

	static public function generateHash (array $params, $limit = 20) {
		$typoVersion = self::getTypoVersion();

        $regHash_calc = self::calculateCacheHash($params);
        $result = substr($regHash_calc, 0, $limit);
		return $result;
	}

	/**
	 * Merges two arrays recursively and "binary safe" (integer keys are
	 * overridden as well), overruling similar values in the original array
	 * with the values of the overrule array.
	 * In case of identical keys, ie. keeping the values of the overrule array.
	 *
	 * This method takes the original array by reference for speed optimization with large arrays
	 *
	 * The differences to the existing PHP function array_merge_recursive() are:
	 *  * Keys of the original array can be unset via the overrule array. ($enableUnsetFeature)
	 *  * Much more control over what is actually merged. ($addKeys, $includeEmptyValues)
	 *  * Elements or the original array get overwritten if the same key is present in the overrule array.
	 *
	 * @param array $original Original array. It will be *modified* by this method and contains the result afterwards!
	 * @param array $overrule Overrule array, overruling the original array
	 * @param boolean $addKeys If set to FALSE, keys that are NOT found in $original will not be set. Thus only existing value can/will be overruled from overrule array.
	 * @param boolean $includeEmptyValues If set, values from $overrule will overrule if they are empty or zero.
	 * @param boolean $enableUnsetFeature If set, special values "__UNSET" can be used in the overrule array in order to unset array keys in the original array.
	 * @return boolean TRUE if the TYPO3 call to mergeRecursiveWithOverrule has been executed
	 */
	static public function mergeRecursiveWithOverrule (array &$original, array $overrule, $addKeys = TRUE, $includeEmptyValues = TRUE, $enableUnsetFeature = TRUE) {
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($original, $overrule, $addKeys, $includeEmptyValues, $enableUnsetFeature);
		return true;
	}

    /**
     * Returns a subpart from the input content stream.
     * A subpart is a part of the input stream which is encapsulated in a
     * string matching the input string, $marker. If this string is found
     * inside of HTML comment tags the start/end points of the content block
     * returned will be that right outside that comment block.
     * Example: The contennt string is
     * "Hello <!--###sub1### begin--> World. How are <!--###sub1### end--> you?"
     * If $marker is "###sub1###" then the content returned is
     * " World. How are ". The input content string could just as well have
     * been "Hello ###sub1### World. How are ###sub1### you?" and the result
     * would be the same
     * Wrapper for MarkerBasedTemplateService::getSubpart which behaves identical
     *
     * @param   string      The content stream, typically HTML template content.
     * @param   string      The marker string, typically on the form "###[the marker string]###"
     * @return  string      The subpart found, if found.
     * @see substituteSubpart(), MarkerBasedTemplateService::getSubpart()
     */
    static public function getSubpart ($content, $marker) {

        $templateClassName = '\\TYPO3\\CMS\\Core\\Service\\MarkerBasedTemplateService';

        $utilityClassName = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
        $useClassName = substr($utilityClassName, 1);
        $useTemplateClassName = substr($templateClassName, 1);
        $object = call_user_func($useClassName . '::makeInstance', $useTemplateClassName);
        $result = $object->getSubpart($content, $marker);
        return $result;
    }


    /**
     * Multi substitution function with caching.
     *
     * This function should be a one-stop substitution function for working
     * with HTML-template. It does not substitute by str_replace but by
     * splitting. This secures that the value inserted does not themselves
     * contain markers or subparts.
     *
     * Note that the "caching" won't cache the content of the substition,
     * but only the splitting of the template in various parts. So if you
     * want only one cache-entry per template, make sure you always pass the
     * exact same set of marker/subpart keys. Else you will be flooding the
     * user's cache table.
     *
     * This function takes three kinds of substitutions in one:
     * $markContentArray is a regular marker-array where the 'keys' are
     * substituted in $content with their values
     *
     * $subpartContentArray works exactly like markContentArray only is whole
     * subparts substituted and not only a single marker.
     *
     * $wrappedSubpartContentArray is an array of arrays with 0/1 keys where
     * the subparts pointed to by the main key is wrapped with the 0/1 value
     * alternating.
     *
     * @param string $content The content stream, typically HTML template content.
     * @param array $markContentArray Regular marker-array where the 'keys' are substituted in $content with their values
     * @param array $subpartContentArray Exactly like markContentArray only is whole subparts substituted and not only a single marker.
     * @param array $wrappedSubpartContentArray An array of arrays with 0/1 keys where the subparts pointed to by the main key is wrapped with the 0/1 value alternating.
     * @return string The output content stream
     * @see MarkerBasedTemplateService methods substituteSubpart(), substituteMarker(), substituteMarkerInObject(), TEMPLATE()
     */
    static public function substituteMarkerArrayCached ($content, array $markContentArray = null, array $subpartContentArray = null, array $wrappedSubpartContentArray = null)
    {
        $templateClassName = '\\TYPO3\\CMS\\Core\\Service\\MarkerBasedTemplateService';
        $utilityClassName = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
        $useClassName = substr($utilityClassName, 1);
        $useTemplateClassName = substr($templateClassName, 1);
        $object = call_user_func($useClassName . '::makeInstance', $useTemplateClassName);
        $result = $object->substituteMarkerArrayCached($content, $markContentArray, $subpartContentArray, $wrappedSubpartContentArray);
        return $result;
    }
    

	### SQL

	/**
	 * deprecated. Use getSystemFields from the class TableUtility
	 * @return array
	 */
	static public function getSystemFields () {
		return self::$systemFields;
	}

	/**
	 * Returns an array containing the regular field names.
	 * deprecated. Use getFields from the class TableUtility
	 *
	 * @return array
	 */
	static public function getFields ($table) {
		$result = FALSE;

		if (is_array($GLOBALS['TCA'][$table]['columns'])) {
			$tcaFields = array_keys($GLOBALS['TCA'][$table]['columns']);
			$systemFields = self::getSystemFields();
			$result = array_diff($tcaFields, $systemFields);
		}

		return $result;
	}


	### TYPO3 7

	/**
	 * deprecated
	 * Call this method under TYPO3 7.x to get backwards compatibility by defining the former class names of TYPO3 6 and 4
	 * @return void
	 */
	static public function activateCompatibility6 () {
        // nothing
        // The migrations folder already cares for the backwards compatibility.
	}

    ### $GLOBALS['TSFE']

    /**
     * Converts the charset of the input string if applicable.
     * The "to" charset is determined by the currently used charset for the page which is "utf-8" by default or set by $GLOBALS['TSFE']->config['config']['renderCharset']
     * Only if there is a difference between the two charsets will a conversion be made
     * The conversion is done real-time - no caching for performance at this point!
     *
     * @param string $str String to convert charset for
     * @param string $from Optional "from" charset.
     * @return string Output string, converted if needed.
     * @see CharsetConverter
     */
    static public function csConv ($str, $from = '')
    {
        $converterClassName = '\\TYPO3\\CMS\\Core\\Charset\\CharsetConverter';
        $result = '';

        $useConverterClassName = substr($converterClassName, 1);

        $callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\GeneralUtility';
        $useClassName = substr($callingClassName, 1);
        /** @var \TYPO3\CMS\Core\Charset\CharsetConverter $charsetConverter */
        $charsetConverter = call_user_func($useClassName . '::makeInstance', $useConverterClassName);

        $result = $charsetConverter->conv($str, trim(strtolower($from)), 'utf-8');

        if (!$result) {
            $result = $str;
        }

        return $result;
    }

     /**
     * Returns TRUE if the current TYPO3 version (or compatibility version) is compatible to the input version
     * Notice that this function compares branches, not versions (4.0.1 would be > 4.0.0 although they use the same compat_version)
     *
     * @param string $verNumberStr Minimum branch number required (format x.y / e.g. "4.0" NOT "4.0.0"!)
     * @return bool Returns TRUE if this setup is compatible with the provided version number
     * @todo Still needs a function to convert versions to branches
     */
    static public function compat_version ($verNumberStr)
    {
        $result = FALSE;
        $useClassName = '';

        $callingClassName = '\\TYPO3\\CMS\\Core\\Utility\\VersionNumberUtility';
        $useClassName = substr($callingClassName, 1);
        $result =
            call_user_func($useClassName . '::convertVersionNumberToInteger', TYPO3_branch) >=
            call_user_func($useClassName . '::convertVersionNumberToInteger', $verNumberStr);

        $useClassName = '';

        if (
            $useClassName &&
            method_exists($callingClassName, 'compat_version')
        ) {
            $result = call_user_func($useClassName . '::compat_version', $verNumberStr);
        }

        return $result;
    }
}

