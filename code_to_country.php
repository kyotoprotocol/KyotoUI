<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("admin/config.php");

        $simulation = new SimulationModel();    // instantiate collection model
            
        // Load specific simulation
        $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        $countries = $sim->getCountries();      // populate countries array from collection

$json = <<<EOF
{"AFG": "Afghanistan", "ALB": "Albania", "DZA": "Algeria", "ASM": "American Samoa", "AND": "Andorra", "AGO": "Angola", "AIA": "Anguilla", "ATG": "Antigua & Barbuda", "ARG": "Argentina", "ARM": "Armenia", "ABW": "Aruba", "AUS": "Australia", "AUT": "Austria", "AZE": "Azerbaijan", "BHS": "Bahamas", "BHR": "Bahrain", "BGD": "Bangladesh", "BRB": "Barbados", "BLR": "Belarus", "BEL": "Belgium", "BLZ": "Belize", "BEN": "Benin", "BMU": "Bermuda", "BTN": "Bhutan", "BOL": "Bolivia", "BIH": "Bosnia and Herzegovina", "BWA": "Botswana", "BRA": "Brazil", "BRN": "Brunei Darussalam", "BGR": "Bulgaria", "BFA": "Burkina Faso", "BDI": "Burundi", "KHM": "Cambodia", "CMR": "Cameroon", "CAN": "Canada", "CPV": "Cape Verde", "CYM": "Cayman Islands", "CAF": "Central African Republic", "TCD": "Chad", "CHL": "Chile", "CHN": "China", "COL": "Colombia", "COM": "Comoros", "COG": "Congo", "COD": "Congo, the Democratic Republic of the", "COK": "Cook Islands", "CRI": "Costa Rica", "CIV": "Cote d'Ivoire", "HRV": "Croatia", "CUB": "Cuba", "CYP": "Cyprus", "CZE": "Czech Republic", "DNK": "Denmark", "DJI": "Djibouti", "DMA": "Dominica", "DOM": "Dominican Republic", "ECU": "Ecuador", "EGY": "Egypt", "SLV": "El Salvador", "GNQ": "Equatorial Guinea", "ERI": "Eritrea", "EST": "Estonia", "ETH": "Ethiopia", "FLK": "Falkland Islands (Malvinas)", "FRO": "Faroe Islands", "FJI": "Fiji", "FIN": "Finland", "FRA": "France", "GUF": "French Guiana", "PYF": "French Polynesia", "GAB": "Gabon", "GMB": "Gambia", "GEO": "Georgia", "DEU": "Germany", "GHA": "Ghana", "GIB": "Gibraltar", "GRC": "Greece", "GRL": "Greenland", "GRD": "Grenada", "GLP": "Guadeloupe", "GUM": "Guam", "GTM": "Guatemala", "GIN": "Guinea", "GNB": "Guinea-Bissau", "GUY": "Guyana", "HTI": "Haiti", "HND": "Honduras", "HKG": "Hong Kong", "HUN": "Hungary", "ISL": "Iceland", "IND": "India", "IDN": "Indonesia", "IRN": "Iran, Islamic Republic of", "IRQ": "Iraq", "IRL": "Ireland", "ISR": "Israel", "ITA": "Italy", "JAM": "Jamaica", "JPN": "Japan", "JOR": "Jordan", "KAZ": "Kazakhstan", "KEN": "Kenya", "KIR": "Kiribati", "PRK": "Korea, Democratic People\u2019s Republic of", "KOR": "Korea, Republic of", "KWT": "Kuwait", "KGZ": "Kyrgyzstan", "LAO": "Lao People\u2019s Democratic Republic", "LVA": "Latvia", "LBN": "Lebanon", "LSO": "Lesotho", "LBR": "Liberia", "LBY": "Libyan Arab Jamahiriya", "LIE": "Liechtenstein", "LTU": "Lithuania", "LUX": "Luxembourg", "MAC": "Macau", "MKD": "Macedonia, the former Yugoslav Republic of", "MDG": "Madagascar", "MWI": "Malawi", "MYS": "Malaysia", "MDV": "Maldives", "MLI": "Mali", "MLT": "Malta", "MHL": "Marshall Islands", "MTQ": "Martinique", "MRT": "Mauritania", "MUS": "Mauritius", "MYT": "Mayotte", "MEX": "Mexico", "FSM": "Micronesia, Federated States of", "MDA": "Moldova, Republic of", "MCO": "Monaco", "MNG": "Mongolia", "MSR": "Montserrat", "MAR": "Morocco", "MOZ": "Mozambique", "MMR": "Myanmar", "NAM": "Namibia", "NRU": "Nauru", "NPL": "Nepal", "NLD": "Netherlands", "ANT": "Netherlands Antilles", "NCL": "New Caledonia", "NZL": "New Zealand", "NIC": "Nicaragua", "NER": "Niger", "NGA": "Nigeria", "NIU": "Niue", "NFK": "Norfolk Island", "MNP": "Northern Mariana Islands", "NOR": "Norway", "OMN": "Oman", "PAK": "Pakistan", "PLW": "Palau", "PSE": "Palestinian Territory, Occupied ", "PAN": "Panama", "PNG": "Papua New Guinea", "PRY": "Paraguay", "PER": "Peru", "PHL": "Philippines", "POL": "Poland", "PRT": "Portugal", "PRI": "Puerto Rico", "QAT": "Qatar", "REU": "Reunion", "ROU": "Romania", "RUS": "Russian Federation", "RWA": "Rwanda", "SHN": "Saint Helena", "KNA": "Saint Kitts and Nevis", "LCA": "Saint Lucia", "SPM": "Saint Pierre and Miquelon", "VCT": "Saint Vincent and the Grenadines", "WSM": "Samoa", "SMR": "San Marino", "STP": "Sao Tome and Principe", "SAU": "Saudi Arabia", "SEN": "Senegal", "SCG": "Serbia and Montenegro", "SYC": "Seychelles", "SLE": "Sierra Leone", "SGP": "Singapore", "SVK": "Slovakia", "SVN": "Slovenia", "SLB": "Solomon Islands", "SOM": "Somalia", "ZAF": "South Africa", "ESP": "Spain", "LKA": "Sri Lanka", "SDN": "Sudan", "SUR": "Suriname", "SWZ": "Swaziland", "SWE": "Sweden", "CHE": "Switzerland", "SYR": "Syrian Arab Republic", "TWN": "Taiwan", "TJK": "Tajikistan", "TZA": "Tanzania, United Republic of", "THA": "Thailand", "TLS": "Timor Leste", "TGO": "Togo", "TKL": "Tokelau", "TON": "Tonga", "TTO": "Trinidad and Tobago", "TUN": "Tunisia", "TUR": "Turkey", "TKM": "Turkmenistan", "TCA": "Turks and Caicos", "TUV": "Tuvalu", "UGA": "Uganda", "UKR": "Ukraine", "ARE": "United Arab Emirates", "GBR": "United Kingdom", "USA": "United States of America", "URY": "Uruguay", "UZB": "Uzbekistan", "VUT": "Vanuatu", "VEN": "Venezuela", "VNM": "Viet Nam", "VGB": "Virgin Islands, British ", "VIR": "Virgin Islands, U.S.", "WLF": "Wallis and Futuna", "YEM": "Yemen", "ZMB": "Zambia", "ZWE": "Zimbabwe", "ESH": "Western Sahara"}
EOF;
    

    $codes_of_countries = json_decode($json);
    
    foreach ($codes_of_countries as $country => $name) {
       if (isset($countries[$country])) {
        $new_codes_of_countries[$country] = $name;
       } else {
      //     echo $country . ' : ' . $name;
        $new_codes_of_countries[$country] = $name . ' **Not Simulated**';
       }
    }

//var_dump($new_codes_of_countries);

header('content-type: application/json');
echo json_encode($new_codes_of_countries);

?>
