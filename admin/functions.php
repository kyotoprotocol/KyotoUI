<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */




function runningIds(){
    $running = shell_exec('ps -ef | grep java');
    preg_match_all('/run [0-9]*/',$running,$matches);
    foreach($matches as $match){
        $returnArry[] = (int)str_replace('run ', '', $match);
    }
    return $returnArry;
}














// Conversion stuff :)


function toISO3($iso){
   switch($iso){
        case 'AF': return 'AFG';
        case 'AX': return 'ALA';
        case 'AL': return 'ALB';
        case 'DZ': return 'DZA';
        case 'AS': return 'ASM';
        case 'AD': return 'AND';
        case 'AO': return 'AGO';
        case 'AI': return 'AIA';
        case 'AQ': return 'ATA';
        case 'AG': return 'ATG';
        case 'AR': return 'ARG';
        case 'AM': return 'ARM';
        case 'AW': return 'ABW';
        case 'AU': return 'AUS';
        case 'AT': return 'AUT';
        case 'AZ': return 'AZE';
        case 'BS': return 'BHS';
        case 'BH': return 'BHR';
        case 'BD': return 'BGD';
        case 'BB': return 'BRB';
        case 'BY': return 'BLR';
        case 'BE': return 'BEL';
        case 'BZ': return 'BLZ';
        case 'BJ': return 'BEN';
        case 'BM': return 'BMU';
        case 'BT': return 'BTN';
        case 'BO': return 'BOL';
        case 'BQ': return 'BES';
        case 'BA': return 'BIH';
        case 'BW': return 'BWA';
        case 'BV': return 'BVT';
        case 'BR': return 'BRA';
        case 'IO': return 'IOT';
        case 'BN': return 'BRN';
        case 'BG': return 'BGR';
        case 'BF': return 'BFA';
        case 'BI': return 'BDI';
        case 'KH': return 'KHM';
        case 'CM': return 'CMR';
        case 'CA': return 'CAN';
        case 'CV': return 'CPV';
        case 'KY': return 'CYM';
        case 'CF': return 'CAF';
        case 'TD': return 'TCD';
        case 'CL': return 'CHL';
        case 'CN': return 'CHN';
        case 'CX': return 'CXR';
        case 'CC': return 'CCK';
        case 'CO': return 'COL';
        case 'KM': return 'COM';
        case 'CG': return 'COG';
        case 'CD': return 'COD';
        case 'CK': return 'COK';
        case 'CR': return 'CRI';
        case 'CI': return 'CIV';
        case 'HR': return 'HRV';
        case 'CU': return 'CUB';
        case 'CW': return 'CUW';
        case 'CY': return 'CYP';
        case 'CZ': return 'CZE';
        case 'DK': return 'DNK';
        case 'DJ': return 'DJI';
        case 'DM': return 'DMA';
        case 'DO': return 'DOM';
        case 'EC': return 'ECU';
        case 'EG': return 'EGY';
        case 'SV': return 'SLV';
        case 'GQ': return 'GNQ';
        case 'ER': return 'ERI';
        case 'EE': return 'EST';
        case 'ET': return 'ETH';
        case 'FK': return 'FLK';
        case 'FO': return 'FRO';
        case 'FJ': return 'FJI';
        case 'FI': return 'FIN';
        case 'FR': return 'FRA';
        case 'GF': return 'GUF';
        case 'PF': return 'PYF';
        case 'TF': return 'ATF';
        case 'GA': return 'GAB';
        case 'GM': return 'GMB';
        case 'GE': return 'GEO';
        case 'DE': return 'DEU';
        case 'GH': return 'GHA';
        case 'GI': return 'GIB';
        case 'GR': return 'GRC';
        case 'GL': return 'GRL';
        case 'GD': return 'GRD';
        case 'GP': return 'GLP';
        case 'GU': return 'GUM';
        case 'GT': return 'GTM';
        case 'GG': return 'GGY';
        case 'GN': return 'GIN';
        case 'GW': return 'GNB';
        case 'GY': return 'GUY';
        case 'HT': return 'HTI';
        case 'HM': return 'HMD';
        case 'VA': return 'VAT';
        case 'HN': return 'HND';
        case 'HK': return 'HKG';
        case 'HU': return 'HUN';
        case 'IS': return 'ISL';
        case 'IN': return 'IND';
        case 'ID': return 'IDN';
        case 'IR': return 'IRN';
        case 'IQ': return 'IRQ';
        case 'IE': return 'IRL';
        case 'IM': return 'IMN';
        case 'IL': return 'ISR';
        case 'IT': return 'ITA';
        case 'JM': return 'JAM';
        case 'JP': return 'JPN';
        case 'JE': return 'JEY';
        case 'JO': return 'JOR';
        case 'KZ': return 'KAZ';
        case 'KE': return 'KEN';
        case 'KI': return 'KIR';
        case 'KP': return 'PRK';
        case 'KR': return 'KOR';
        case 'KW': return 'KWT';
        case 'KG': return 'KGZ';
        case 'LA': return 'LAO';
        case 'LV': return 'LVA';
        case 'LB': return 'LBN';
        case 'LS': return 'LSO';
        case 'LR': return 'LBR';
        case 'LY': return 'LBY';
        case 'LI': return 'LIE';
        case 'LT': return 'LTU';
        case 'LU': return 'LUX';
        case 'MO': return 'MAC';
        case 'MK': return 'MKD';
        case 'MG': return 'MDG';
        case 'MW': return 'MWI';
        case 'MY': return 'MYS';
        case 'MV': return 'MDV';
        case 'ML': return 'MLI';
        case 'MT': return 'MLT';
        case 'MH': return 'MHL';
        case 'MQ': return 'MTQ';
        case 'MR': return 'MRT';
        case 'MU': return 'MUS';
        case 'YT': return 'MYT';
        case 'MX': return 'MEX';
        case 'FM': return 'FSM';
        case 'MD': return 'MDA';
        case 'MC': return 'MCO';
        case 'MN': return 'MNG';
        case 'ME': return 'MNE';
        case 'MS': return 'MSR';
        case 'MA': return 'MAR';
        case 'MZ': return 'MOZ';
        case 'MM': return 'MMR';
        case 'NA': return 'NAM';
        case 'NR': return 'NRU';
        case 'NP': return 'NPL';
        case 'NL': return 'NLD';
        case 'NC': return 'NCL';
        case 'NZ': return 'NZL';
        case 'NI': return 'NIC';
        case 'NE': return 'NER';
        case 'NG': return 'NGA';
        case 'NU': return 'NIU';
        case 'NF': return 'NFK';
        case 'MP': return 'MNP';
        case 'NO': return 'NOR';
        case 'OM': return 'OMN';
        case 'PK': return 'PAK';
        case 'PW': return 'PLW';
        case 'PS': return 'PSE';
        case 'PA': return 'PAN';
        case 'PG': return 'PNG';
        case 'PY': return 'PRY';
        case 'PE': return 'PER';
        case 'PH': return 'PHL';
        case 'PN': return 'PCN';
        case 'PL': return 'POL';
        case 'PT': return 'PRT';
        case 'PR': return 'PRI';
        case 'QA': return 'QAT';
        case 'RE': return 'REU';
        case 'RO': return 'ROU';
        case 'RU': return 'RUS';
        case 'RW': return 'RWA';
        case 'BL': return 'BLM';
        case 'SH': return 'SHN';
        case 'KN': return 'KNA';
        case 'LC': return 'LCA';
        case 'MF': return 'MAF';
        case 'PM': return 'SPM';
        case 'VC': return 'VCT';
        case 'WS': return 'WSM';
        case 'SM': return 'SMR';
        case 'ST': return 'STP';
        case 'SA': return 'SAU';
        case 'SN': return 'SEN';
        case 'RS': return 'SRB';
        case 'SC': return 'SYC';
        case 'SL': return 'SLE';
        case 'SG': return 'SGP';
        case 'SX': return 'SXM';
        case 'SK': return 'SVK';
        case 'SI': return 'SVN';
        case 'SB': return 'SLB';
        case 'SO': return 'SOM';
        case 'ZA': return 'ZAF';
        case 'GS': return 'SGS';
        case 'SS': return 'SSD';
        case 'ES': return 'ESP';
        case 'LK': return 'LKA';
        case 'SD': return 'SDN';
        case 'SR': return 'SUR';
        case 'SJ': return 'SJM';
        case 'SZ': return 'SWZ';
        case 'SE': return 'SWE';
        case 'CH': return 'CHE';
        case 'SY': return 'SYR';
        case 'TW': return 'TWN';
        case 'TJ': return 'TJK';
        case 'TZ': return 'TZA';
        case 'TH': return 'THA';
        case 'TL': return 'TLS';
        case 'TG': return 'TGO';
        case 'TK': return 'TKL';
        case 'TO': return 'TON';
        case 'TT': return 'TTO';
        case 'TN': return 'TUN';
        case 'TR': return 'TUR';
        case 'TM': return 'TKM';
        case 'TC': return 'TCA';
        case 'TV': return 'TUV';
        case 'UG': return 'UGA';
        case 'UA': return 'UKR';
        case 'AE': return 'ARE';
        case 'GB': return 'GBR';
        case 'US': return 'USA';
        case 'UM': return 'UMI';
        case 'UY': return 'URY';
        case 'UZ': return 'UZB';
        case 'VU': return 'VUT';
        case 'VE': return 'VEN';
        case 'VN': return 'VNM';
        case 'VG': return 'VGB';
        case 'VI': return 'VIR';
        case 'WF': return 'WLF';
        case 'EH': return 'ESH';
        case 'YE': return 'YEM';
        case 'ZM': return 'ZMB';
        case 'ZW': return 'ZWE'; 
        default: return $iso;
            
   }
}

function toISO2($iso){
    switch ($iso) {
            case 'AFG' : return 'AF';
            case 'ALA' : return 'AX';
            case 'ALB' : return 'AL';
            case 'DZA' : return 'DZ';
            case 'ASM' : return 'AS';
            case 'AND' : return 'AD';
            case 'AGO' : return 'AO';
            case 'AIA' : return 'AI';
            case 'ATA' : return 'AQ';
            case 'ATG' : return 'AG';
            case 'ARG' : return 'AR';
            case 'ARM' : return 'AM';
            case 'ABW' : return 'AW';
            case 'AUS' : return 'AU';
            case 'AUT' : return 'AT';
            case 'AZE' : return 'AZ';
            case 'BHS' : return 'BS';
            case 'BHR' : return 'BH';
            case 'BGD' : return 'BD';
            case 'BRB' : return 'BB';
            case 'BLR' : return 'BY';
            case 'BEL' : return 'BE';
            case 'BLZ' : return 'BZ';
            case 'BEN' : return 'BJ';
            case 'BMU' : return 'BM';
            case 'BTN' : return 'BT';
            case 'BOL' : return 'BO';
            case 'BES' : return 'BQ';
            case 'BIH' : return 'BA';
            case 'BWA' : return 'BW';
            case 'BVT' : return 'BV';
            case 'BRA' : return 'BR';
            case 'IOT' : return 'IO';
            case 'BRN' : return 'BN';
            case 'BGR' : return 'BG';
            case 'BFA' : return 'BF';
            case 'BDI' : return 'BI';
            case 'KHM' : return 'KH';
            case 'CMR' : return 'CM';
            case 'CAN' : return 'CA';
            case 'CPV' : return 'CV';
            case 'CYM' : return 'KY';
            case 'CAF' : return 'CF';
            case 'TCD' : return 'TD';
            case 'CHL' : return 'CL';
            case 'CHN' : return 'CN';
            case 'CXR' : return 'CX';
            case 'CCK' : return 'CC';
            case 'COL' : return 'CO';
            case 'COM' : return 'KM';
            case 'COG' : return 'CG';
            case 'COD' : return 'CD';
            case 'COK' : return 'CK';
            case 'CRI' : return 'CR';
            case 'CIV' : return 'CI';
            case 'HRV' : return 'HR';
            case 'CUB' : return 'CU';
            case 'CUW' : return 'CW';
            case 'CYP' : return 'CY';
            case 'CZE' : return 'CZ';
            case 'DNK' : return 'DK';
            case 'DJI' : return 'DJ';
            case 'DMA' : return 'DM';
            case 'DOM' : return 'DO';
            case 'ECU' : return 'EC';
            case 'EGY' : return 'EG';
            case 'SLV' : return 'SV';
            case 'GNQ' : return 'GQ';
            case 'ERI' : return 'ER';
            case 'EST' : return 'EE';
            case 'ETH' : return 'ET';
            case 'FLK' : return 'FK';
            case 'FRO' : return 'FO';
            case 'FJI' : return 'FJ';
            case 'FIN' : return 'FI';
            case 'FRA' : return 'FR';
            case 'GUF' : return 'GF';
            case 'PYF' : return 'PF';
            case 'ATF' : return 'TF';
            case 'GAB' : return 'GA';
            case 'GMB' : return 'GM';
            case 'GEO' : return 'GE';
            case 'DEU' : return 'DE';
            case 'GHA' : return 'GH';
            case 'GIB' : return 'GI';
            case 'GRC' : return 'GR';
            case 'GRL' : return 'GL';
            case 'GRD' : return 'GD';
            case 'GLP' : return 'GP';
            case 'GUM' : return 'GU';
            case 'GTM' : return 'GT';
            case 'GGY' : return 'GG';
            case 'GIN' : return 'GN';
            case 'GNB' : return 'GW';
            case 'GUY' : return 'GY';
            case 'HTI' : return 'HT';
            case 'HMD' : return 'HM';
            case 'VAT' : return 'VA';
            case 'HND' : return 'HN';
            case 'HKG' : return 'HK';
            case 'HUN' : return 'HU';
            case 'ISL' : return 'IS';
            case 'IND' : return 'IN';
            case 'IDN' : return 'ID';
            case 'IRN' : return 'IR';
            case 'IRQ' : return 'IQ';
            case 'IRL' : return 'IE';
            case 'IMN' : return 'IM';
            case 'ISR' : return 'IL';
            case 'ITA' : return 'IT';
            case 'JAM' : return 'JM';
            case 'JPN' : return 'JP';
            case 'JEY' : return 'JE';
            case 'JOR' : return 'JO';
            case 'KAZ' : return 'KZ';
            case 'KEN' : return 'KE';
            case 'KIR' : return 'KI';
            case 'PRK' : return 'KP';
            case 'KOR' : return 'KR';
            case 'KWT' : return 'KW';
            case 'KGZ' : return 'KG';
            case 'LAO' : return 'LA';
            case 'LVA' : return 'LV';
            case 'LBN' : return 'LB';
            case 'LSO' : return 'LS';
            case 'LBR' : return 'LR';
            case 'LBY' : return 'LY';
            case 'LIE' : return 'LI';
            case 'LTU' : return 'LT';
            case 'LUX' : return 'LU';
            case 'MAC' : return 'MO';
            case 'MKD' : return 'MK';
            case 'MDG' : return 'MG';
            case 'MWI' : return 'MW';
            case 'MYS' : return 'MY';
            case 'MDV' : return 'MV';
            case 'MLI' : return 'ML';
            case 'MLT' : return 'MT';
            case 'MHL' : return 'MH';
            case 'MTQ' : return 'MQ';
            case 'MRT' : return 'MR';
            case 'MUS' : return 'MU';
            case 'MYT' : return 'YT';
            case 'MEX' : return 'MX';
            case 'FSM' : return 'FM';
            case 'MDA' : return 'MD';
            case 'MCO' : return 'MC';
            case 'MNG' : return 'MN';
            case 'MNE' : return 'ME';
            case 'MSR' : return 'MS';
            case 'MAR' : return 'MA';
            case 'MOZ' : return 'MZ';
            case 'MMR' : return 'MM';
            case 'NAM' : return 'NA';
            case 'NRU' : return 'NR';
            case 'NPL' : return 'NP';
            case 'NLD' : return 'NL';
            case 'NCL' : return 'NC';
            case 'NZL' : return 'NZ';
            case 'NIC' : return 'NI';
            case 'NER' : return 'NE';
            case 'NGA' : return 'NG';
            case 'NIU' : return 'NU';
            case 'NFK' : return 'NF';
            case 'MNP' : return 'MP';
            case 'NOR' : return 'NO';
            case 'OMN' : return 'OM';
            case 'PAK' : return 'PK';
            case 'PLW' : return 'PW';
            case 'PSE' : return 'PS';
            case 'PAN' : return 'PA';
            case 'PNG' : return 'PG';
            case 'PRY' : return 'PY';
            case 'PER' : return 'PE';
            case 'PHL' : return 'PH';
            case 'PCN' : return 'PN';
            case 'POL' : return 'PL';
            case 'PRT' : return 'PT';
            case 'PRI' : return 'PR';
            case 'QAT' : return 'QA';
            case 'REU' : return 'RE';
            case 'ROU' : return 'RO';
            case 'RUS' : return 'RU';
            case 'RWA' : return 'RW';
            case 'BLM' : return 'BL';
            case 'SHN' : return 'SH';
            case 'KNA' : return 'KN';
            case 'LCA' : return 'LC';
            case 'MAF' : return 'MF';
            case 'SPM' : return 'PM';
            case 'VCT' : return 'VC';
            case 'WSM' : return 'WS';
            case 'SMR' : return 'SM';
            case 'STP' : return 'ST';
            case 'SAU' : return 'SA';
            case 'SEN' : return 'SN';
            case 'SRB' : return 'RS';
            case 'SYC' : return 'SC';
            case 'SLE' : return 'SL';
            case 'SGP' : return 'SG';
            case 'SXM' : return 'SX';
            case 'SVK' : return 'SK';
            case 'SVN' : return 'SI';
            case 'SLB' : return 'SB';
            case 'SOM' : return 'SO';
            case 'ZAF' : return 'ZA';
            case 'SGS' : return 'GS';
            case 'SSD' : return 'SS';
            case 'ESP' : return 'ES';
            case 'LKA' : return 'LK';
            case 'SDN' : return 'SD';
            case 'SUR' : return 'SR';
            case 'SJM' : return 'SJ';
            case 'SWZ' : return 'SZ';
            case 'SWE' : return 'SE';
            case 'CHE' : return 'CH';
            case 'SYR' : return 'SY';
            case 'TWN' : return 'TW';
            case 'TJK' : return 'TJ';
            case 'TZA' : return 'TZ';
            case 'THA' : return 'TH';
            case 'TLS' : return 'TL';
            case 'TGO' : return 'TG';
            case 'TKL' : return 'TK';
            case 'TON' : return 'TO';
            case 'TTO' : return 'TT';
            case 'TUN' : return 'TN';
            case 'TUR' : return 'TR';
            case 'TKM' : return 'TM';
            case 'TCA' : return 'TC';
            case 'TUV' : return 'TV';
            case 'UGA' : return 'UG';
            case 'UKR' : return 'UA';
            case 'ARE' : return 'AE';
            case 'GBR' : return 'GB';
            case 'USA' : return 'US';
            case 'UMI' : return 'UM';
            case 'URY' : return 'UY';
            case 'UZB' : return 'UZ';
            case 'VUT' : return 'VU';
            case 'VEN' : return 'VE';
            case 'VNM' : return 'VN';
            case 'VGB' : return 'VG';
            case 'VIR' : return 'VI';
            case 'WLF' : return 'WF';
            case 'ESH' : return 'EH';
            case 'YEM' : return 'YE';
            case 'ZMB' : return 'ZM';
            case 'ZWE' : return 'ZW';
            default: return ($iso);
    }
}
?>