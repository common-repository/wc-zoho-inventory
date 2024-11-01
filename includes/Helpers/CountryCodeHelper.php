<?php

namespace BitPress\BIT_WC_ZOHO_INVENTORY\Helpers;

final class CountryCodeHelper
{
    public $mergedCountries;

    public function __construct()
    {
        $this->mergedCountries = array_merge($this->wcCountries, $this->zohoCountries);
    }

    public function getCountryName($countryCode)
    {
        return isset($this->mergedCountries[$countryCode]) ? $this->mergedCountries[$countryCode] : $countryCode;
    }

    public $wcCountries = [
      "AF"=> "Afghanistan",
      "AX"=> "Åland Islands",
      "AL"=> "Albania",
      "DZ"=> "Algeria",
      "AS"=> "American Samoa",
      "AD"=> "Andorra",
      "AO"=> "Angola",
      "AI"=> "Anguilla",
      "AQ"=> "Antarctica",
      "AG"=> "Antigua and Barbuda",
      "AR"=> "Argentina",
      "AM"=> "Armenia",
      "AW"=> "Aruba",
      "AU"=> "Australia",
      "AT"=> "Austria",
      "AZ"=> "Azerbaijan",
      "BS"=> "Bahamas",
      "BH"=> "Bahrain",
      "BD"=> "Bangladesh",
      "BB"=> "Barbados",
      "BY"=> "Belarus",
      "PW"=> "Belau",
      "BE"=> "Belgium",
      "BZ"=> "Belize",
      "BJ"=> "Benin",
      "BM"=> "Bermuda",
      "BT"=> "Bhutan",
      "BO"=> "Bolivia",
      "BQ"=> "Bonaire, Saint Eustatius and Saba",
      "BA"=> "Bosnia and Herzegovina",
      "BW"=> "Botswana",
      "BV"=> "Bouvet Island",
      "BR"=> "Brazil",
      "IO"=> "British Indian Ocean Territory",
      "BN"=> "Brunei",
      "BG"=> "Bulgaria",
      "BF"=> "Burkina Faso",
      "BI"=> "Burundi",
      "KH"=> "Cambodia",
      "CM"=> "Cameroon",
      "CA"=> "Canada",
      "CV"=> "Cape Verde",
      "KY"=> "Cayman Islands",
      "CF"=> "Central African Republic",
      "TD"=> "Chad",
      "CL"=> "Chile",
      "CN"=> "China",
      "CX"=> "Christmas Island",
      "CC"=> "Cocos (Keeling) Islands",
      "CO"=> "Colombia",
      "KM"=> "Comoros",
      "CG"=> "Congo (Brazzaville)",
      "CD"=> "Congo (Kinshasa)",
      "CK"=> "Cook Islands",
      "CR"=> "Costa Rica",
      "HR"=> "Croatia",
      "CU"=> "Cuba",
      "CW"=> "Curaçao",
      "CY"=> "Cyprus",
      "CZ"=> "Czech Republic",
      "DK"=> "Denmark",
      "DJ"=> "Djibouti",
      "DM"=> "Dominica",
      "DO"=> "Dominican Republic",
      "EC"=> "Ecuador",
      "EG"=> "Egypt",
      "SV"=> "El Salvador",
      "GQ"=> "Equatorial Guinea",
      "ER"=> "Eritrea",
      "EE"=> "Estonia",
      "SZ"=> "Eswatini",
      "ET"=> "Ethiopia",
      "FK"=> "Falkland Islands",
      "FO"=> "Faroe Islands",
      "FJ"=> "Fiji",
      "FI"=> "Finland",
      "FR"=> "France",
      "GF"=> "French Guiana",
      "PF"=> "French Polynesia",
      "TF"=> "French Southern Territories",
      "GA"=> "Gabon",
      "GM"=> "Gambia",
      "GE"=> "Georgia",
      "DE"=> "Germany",
      "GH"=> "Ghana",
      "GI"=> "Gibraltar",
      "GR"=> "Greece",
      "GL"=> "Greenland",
      "GD"=> "Grenada",
      "GP"=> "Guadeloupe",
      "GU"=> "Guam",
      "GT"=> "Guatemala",
      "GG"=> "Guernsey",
      "GN"=> "Guinea",
      "GW"=> "Guinea-Bissau",
      "GY"=> "Guyana",
      "HT"=> "Haiti",
      "HM"=> "Heard Island and McDonald Islands",
      "HN"=> "Honduras",
      "HK"=> "Hong Kong",
      "HU"=> "Hungary",
      "IS"=> "Iceland",
      "IN"=> "India",
      "ID"=> "Indonesia",
      "IR"=> "Iran",
      "IQ"=> "Iraq",
      "IE"=> "Ireland",
      "IM"=> "Isle of Man",
      "IL"=> "Israel",
      "IT"=> "Italy",
      "CI"=> "Ivory Coast",
      "JM"=> "Jamaica",
      "JP"=> "Japan",
      "JE"=> "Jersey",
      "JO"=> "Jordan",
      "KZ"=> "Kazakhstan",
      "KE"=> "Kenya",
      "KI"=> "Kiribati",
      "KW"=> "Kuwait",
      "KG"=> "Kyrgyzstan",
      "LA"=> "Laos",
      "LV"=> "Latvia",
      "LB"=> "Lebanon",
      "LS"=> "Lesotho",
      "LR"=> "Liberia",
      "LY"=> "Libya",
      "LI"=> "Liechtenstein",
      "LT"=> "Lithuania",
      "LU"=> "Luxembourg",
      "MO"=> "Macao",
      "MG"=> "Madagascar",
      "MW"=> "Malawi",
      "MY"=> "Malaysia",
      "MV"=> "Maldives",
      "ML"=> "Mali",
      "MT"=> "Malta",
      "MH"=> "Marshall Islands",
      "MQ"=> "Martinique",
      "MR"=> "Mauritania",
      "MU"=> "Mauritius",
      "YT"=> "Mayotte",
      "MX"=> "Mexico",
      "FM"=> "Micronesia",
      "MD"=> "Moldova",
      "MC"=> "Monaco",
      "MN"=> "Mongolia",
      "ME"=> "Montenegro",
      "MS"=> "Montserrat",
      "MA"=> "Morocco",
      "MZ"=> "Mozambique",
      "MM"=> "Myanmar",
      "NA"=> "Namibia",
      "NR"=> "Nauru",
      "NP"=> "Nepal",
      "NL"=> "Netherlands",
      "NC"=> "New Caledonia",
      "NZ"=> "New Zealand",
      "NI"=> "Nicaragua",
      "NE"=> "Niger",
      "NG"=> "Nigeria",
      "NU"=> "Niue",
      "NF"=> "Norfolk Island",
      "KP"=> "North Korea",
      "MK"=> "North Macedonia",
      "MP"=> "Northern Mariana Islands",
      "NO"=> "Norway",
      "OM"=> "Oman",
      "PK"=> "Pakistan",
      "PS"=> "Palestinian Territory",
      "PA"=> "Panama",
      "PG"=> "Papua New Guinea",
      "PY"=> "Paraguay",
      "PE"=> "Peru",
      "PH"=> "Philippines",
      "PN"=> "Pitcairn",
      "PL"=> "Poland",
      "PT"=> "Portugal",
      "PR"=> "Puerto Rico",
      "QA"=> "Qatar",
      "RE"=> "Reunion",
      "RO"=> "Romania",
      "RU"=> "Russia",
      "RW"=> "Rwanda",
      "ST"=> "São Tomé and Príncipe",
      "BL"=> "Saint Barthélemy",
      "SH"=> "Saint Helena",
      "KN"=> "Saint Kitts and Nevis",
      "LC"=> "Saint Lucia",
      "SX"=> "Saint Martin (Dutch part)",
      "MF"=> "Saint Martin (French part)",
      "PM"=> "Saint Pierre and Miquelon",
      "VC"=> "Saint Vincent and the Grenadines",
      "WS"=> "Samoa",
      "SM"=> "San Marino",
      "SA"=> "Saudi Arabia",
      "SN"=> "Senegal",
      "RS"=> "Serbia",
      "SC"=> "Seychelles",
      "SL"=> "Sierra Leone",
      "SG"=> "Singapore",
      "SK"=> "Slovakia",
      "SI"=> "Slovenia",
      "SB"=> "Solomon Islands",
      "SO"=> "Somalia",
      "ZA"=> "South Africa",
      "GS"=> "South Georgia/Sandwich Islands",
      "KR"=> "South Korea",
      "SS"=> "South Sudan",
      "ES"=> "Spain",
      "LK"=> "Sri Lanka",
      "SD"=> "Sudan",
      "SR"=> "Suriname",
      "SJ"=> "Svalbard and Jan Mayen",
      "SE"=> "Sweden",
      "CH"=> "Switzerland",
      "SY"=> "Syria",
      "TW"=> "Taiwan",
      "TJ"=> "Tajikistan",
      "TZ"=> "Tanzania",
      "TH"=> "Thailand",
      "TL"=> "Timor-Leste",
      "TG"=> "Togo",
      "TK"=> "Tokelau",
      "TO"=> "Tonga",
      "TT"=> "Trinidad and Tobago",
      "TN"=> "Tunisia",
      "TR"=> "Turkey",
      "TM"=> "Turkmenistan",
      "TC"=> "Turks and Caicos Islands",
      "TV"=> "Tuvalu",
      "UG"=> "Uganda",
      "UA"=> "Ukraine",
      "AE"=> "United Arab Emirates",
      "GB"=> "United Kingdom (UK)",
      "US"=> "United States (US)",
      "UM"=> "United States (US) Minor Outlying Islands",
      "UY"=> "Uruguay",
      "UZ"=> "Uzbekistan",
      "VU"=> "Vanuatu",
      "VA"=> "Vatican",
      "VE"=> "Venezuela",
      "VN"=> "Vietnam",
      "VG"=> "Virgin Islands (British)",
      "VI"=> "Virgin Islands (US)",
      "WF"=> "Wallis and Futuna",
      "EH"=> "Western Sahara",
      "YE"=> "Yemen",
      "ZM"=> "Zambia",
      "ZW"=> "Zimbabwe"
    ];

    public $zohoCountries = [
      "AF"=> "Afghanistan",
      "AX"=> "Aland Islands",
      "AL"=> "Albania",
      "DZ"=> "Algeria",
      "AS"=> "American Samoa",
      "AD"=> "Andorra",
      "AO"=> "Angola",
      "AI"=> "Anguilla",
      "AQ"=> "Antarctica",
      "AG"=> "Antigua and Barbuda",
      "AR"=> "Argentina",
      "AM"=> "Armenia",
      "AW"=> "Aruba",
      "AC"=> "Ashmore and Cartier Islands",
      "AU"=> "Australia",
      "AT"=> "Austria",
      "AZ"=> "Azerbaijan",
      "BS"=> "Bahamas",
      "BH"=> "Bahrain",
      "BD"=> "Bangladesh",
      "BB"=> "Barbados",
      "BY"=> "Belarus",
      "BE"=> "Belgium",
      "BZ"=> "Belize",
      "BJ"=> "Benin",
      "BM"=> "Bermuda",
      "BT"=> "Bhutan",
      "BO"=> "Bolivia",
      "BQ"=> "Bonaire Sint Eustatius and Saba",
      "BA"=> "Bosnia",
      "BIH"=> "Bosnia and Herzegovina",
      "BW"=> "Botswana",
      "BV"=> "Bouvet Island",
      "BR"=> "Brazil",
      "IO"=> "British Indian Ocean Territory",
      "VG"=> "Virgin Islands British",
      "BN"=> "Brunei",
      "BG"=> "Bulgaria",
      "BF"=> "Burkina Faso",
      "BI"=> "Burundi",
      "KH"=> "Cambodia",
      "CM"=> "Cameroon",
      "CA"=> "Canada",
      "CV"=> "Cape Verde",
      "KY"=> "Cayman Islands",
      "CF"=> "Central African Republic",
      "TD"=> "Chad",
      "CL"=> "Chile",
      "CN"=> "China",
      "CX"=> "Christmas Island",
      "CP"=> "Clipperton Island",
      "CC"=> "Cocos Islands",
      "CO"=> "Colombia",
      "KM"=> "Comoros",
      "CG"=> "Congo",
      "CK"=> "Cook Islands",
      "IC"=> "Coral Sea Islands",
      "CR"=> "Costa Rica",
      "HR"=> "Croatia",
      "CU"=> "Cuba",
      "CW"=> "Curacao",
      "CY"=> "Cyprus",
      "CZ"=> "Czech Republic",
      "CD"=> "DR Congo",
      "DK"=> "Denmark",
      "DJ"=> "Djibouti",
      "DM"=> "Dominica",
      "DO"=> "Dominican Republic",
      "EC"=> "Ecuador",
      "EG"=> "Egypt",
      "SV"=> "El Salvador",
      "GQ"=> "Equatorial Guinea",
      "ER"=> "Eritrea",
      "EE"=> "Estonia",
      "ET"=> "Ethiopia",
      "FK"=> "Falkland Islands",
      "FO"=> "Faroe Islands",
      "FJ"=> "Fiji",
      "FI"=> "Finland",
      "FR"=> "France",
      "GF"=> "French Guiana",
      "PF"=> "French Polynesia",
      "TF"=> "French Southern Territories",
      "GA"=> "Gabon",
      "GM"=> "Gambia",
      "GE"=> "Georgia",
      "DE"=> "Germany",
      "GH"=> "Ghana",
      "GI"=> "Gibraltar",
      "GR"=> "Greece",
      "GL"=> "Greenland",
      "GD"=> "Grenada",
      "GP"=> "Guadeloupe",
      "GU"=> "Guam",
      "GT"=> "Guatemala",
      "GG"=> "Guernsey",
      "GN"=> "Guinea",
      "GW"=> "Guinea-Bissau",
      "GY"=> "Guyana",
      "HT"=> "Haiti",
      "HM"=> "Heard Island and McDonald Islands",
      "XX"=> "High Seas",
      "HN"=> "Honduras",
      "HK"=> "Hong Kong",
      "HU"=> "Hungary",
      "IS"=> "Iceland",
      "IN"=> "India",
      "ID"=> "Indonesia",
      "IR"=> "Iran",
      "IQ"=> "Iraq",
      "IE"=> "Ireland",
      "IM"=> "Isle of Man",
      "IL"=> "Israel",
      "IT"=> "Italy",
      "CI"=> "Côte d'Ivoire",
      "JM"=> "Jamaica",
      "JP"=> "Japan",
      "JE"=> "Jersey",
      "JO"=> "Jordan",
      "KZ"=> "Kazakhstan",
      "KE"=> "Kenya",
      "KI"=> "Kiribati",
      "XK"=> "Kosovo",
      "KW"=> "Kuwait",
      "KG"=> "Kyrgyzstan",
      "LA"=> "Laos",
      "LV"=> "Latvia",
      "LB"=> "Lebanon",
      "LS"=> "Lesotho",
      "LR"=> "Liberia",
      "LY"=> "Libya",
      "LI"=> "Liechtenstein",
      "LT"=> "Lithuania",
      "LU"=> "Luxembourg",
      "MO"=> "Macau",
      "MG"=> "Madagascar",
      "MW"=> "Malawi",
      "MY"=> "Malaysia",
      "MV"=> "Maldives",
      "ML"=> "Mali",
      "MT"=> "Malta",
      "MH"=> "Marshall Islands",
      "MQ"=> "Martinique",
      "MR"=> "Mauritania",
      "MU"=> "Mauritius",
      "YT"=> "Mayotte",
      "MX"=> "Mexico",
      "FM"=> "Micronesia",
      "MD"=> "Moldova",
      "MC"=> "Monaco",
      "MN"=> "Mongolia",
      "ME"=> "Montenegro",
      "MS"=> "Montserrat",
      "MA"=> "Morocco",
      "MZ"=> "Mozambique",
      "MM"=> "Myanmar",
      "NA"=> "Namibia",
      "NR"=> "Nauru",
      "NP"=> "Nepal",
      "NL"=> "Netherlands",
      "AN"=> "Netherlands Antilles",
      "NC"=> "New Caledonia",
      "NZ"=> "New Zealand",
      "NI"=> "Nicaragua",
      "NE"=> "Niger",
      "NG"=> "Nigeria",
      "NU"=> "Niue",
      "NF"=> "Norfolk Island",
      "KP"=> "North Korea",
      "MK"=> "North Macedonia",
      "MP"=> "Northern Mariana Islands",
      "NO"=> "Norway",
      "OM"=> "Oman",
      "PK"=> "Pakistan",
      "PW"=> "Palau",
      "PS"=> "Palestine",
      "PA"=> "Panama",
      "PG"=> "Papua New Guinea",
      "PY"=> "Paraguay",
      "PE"=> "Peru",
      "PH"=> "Philippines",
      "PN"=> "Pitcairn",
      "PL"=> "Poland",
      "PT"=> "Portugal",
      "PR"=> "Puerto Rico",
      "QA"=> "Qatar",
      "RE"=> "Reunion",
      "RO"=> "Romania",
      "RU"=> "Russia",
      "RW"=> "Rwanda",
      "BL"=> "Saint Barthelemy",
      "SH"=> "Saint Helena",
      "KN"=> "Saint Kitts and Nevis",
      "LC"=> "Saint Lucia",
      "MF"=> "Saint Martin",
      "PM"=> "Saint Pierre and Miquelon",
      "VC"=> "Saint Vincent and the Grenadines",
      "WS"=> "Samoa",
      "SM"=> "San Marino",
      "ST"=> "Sao Tome and Principe",
      "SA"=> "Saudi Arabia",
      "SN"=> "Senegal",
      "RS"=> "Serbia",
      "CS"=> "Serbia and Montenegro",
      "SC"=> "Seychelles",
      "SL"=> "Sierra Leone",
      "SG"=> "Singapore",
      "SX"=> "Sint Maarten",
      "SK"=> "Slovakia",
      "SI"=> "Slovenia",
      "SB"=> "Solomon Islands",
      "SO"=> "Somalia",
      "SOM"=> "Somaliland",
      "ZA"=> "South Africa",
      "GS"=> "South Georgia and the South Sandwich Islands",
      "KR"=> "South Korea",
      "SS"=> "South Sudan",
      "ES"=> "Spain",
      "LK"=> "Sri Lanka",
      "SD"=> "Suda",
      "SR"=> "Suriname",
      "SJ"=> "Svalbard and Jan Mayen",
      "SZ"=> "Swaziland",
      "SE"=> "Sweden",
      "CH"=> "Switzerland",
      "SY"=> "Syria",
      "TW"=> "Taiwan",
      "TJ"=> "Tajikistan",
      "TZ"=> "Tanzania",
      "TH"=> "Thailand",
      "TL"=> "Timor Leste",
      "TG"=> "Togo",
      "TK"=> "Tokelau",
      "TO"=> "Tonga",
      "TT"=> "Trinidad and Tobago",
      "TN"=> "Tunisia",
      "TR"=> "Turkey",
      "TM"=> "Turkmenistan",
      "TC"=> "Turks and Caicos Islands",
      "TV"=> "Tuvalu",
      "AE"=> "United Arab Emirates",
      "US"=> "U.S.A",
      "UG"=> "Uganda",
      "UA"=> "Ukraine",
      "GB"=> "United Kingdom",
      "UM"=> "United States Minor Outlying Islands",
      "UY"=> "Uruguay",
      "UZ"=> "Uzbekistan",
      "VU"=> "Vanuatu",
      "VA"=> "Vatican City",
      "VE"=> "Venezuela",
      "VN"=> "Vietnam",
      "VI"=> "Virgin Islands U.S.",
      "WF"=> "Wallis and Futuna",
      "EH"=> "Western Sahara",
      "YE"=> "Yemen",
      "ZM"=> "Zambia",
      "ZW"=> "Zimbabwe"
    ];
}
