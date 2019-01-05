<?php

namespace Lakeview\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Validation\Validator;
use Lakeview\Page;
use Lakeview\Version;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $pageData;
	
	public $return;


	public function __construct() {
		
	
		$mainPage = Page::where('parent',null)->first();
		$navItems = $mainPage->children()->get();
		$uri = request()->server('REQUEST_URI');
		$this->ajax = strpos($uri, 'ajax');
		$this->output = new \stdClass();
		$this->output->status = 'fail';
		$this->output->response = new \stdClass();
		$this->output->errors = null;
				
		$this->pageData = new \stdClass(['title', 'uri']);
		$this->pageData->version = Version::where('active','=',true)->take(1)->get()->first();
		$this->pageData->warnings = array();
		$this->pageData->activeNav = '';
		
		$this->pageData->navItems = $navItems;
		$this->pageData->data = new \stdClass();
		$this->pageData->data->countries = array(
			"AFG" => "Afghanistan",
			"ALA" => "Åland Islands",
			"ALB" => "Albania",
			"DZA" => "Algeria",
			"ASM" => "American Samoa",
			"AND" => "Andorra",
			"AGO" => "Angola",
			"AIA" => "Anguilla",
			"ATA" => "Antarctica",
			"ATG" => "Antigua and Barbuda",
			"ARG" => "Argentina",
			"ARM" => "Armenia",
			"ABW" => "Aruba",
			"AUS" => "Australia",
			"AUT" => "Austria",
			"AZE" => "Azerbaijan",
			"BHS" => "Bahamas",
			"BHR" => "Bahrain",
			"BGD" => "Bangladesh",
			"BRB" => "Barbados",
			"BLR" => "Belarus",
			"BEL" => "Belgium",
			"BLZ" => "Belize",
			"BEN" => "Benin",
			"BMU" => "Bermuda",
			"BTN" => "Bhutan",
			"BOL" => "Bolivia, Plurinational State of",
			"BES" => "Bonaire, Sint Eustatius and Saba",
			"BIH" => "Bosnia and Herzegovina",
			"BWA" => "Botswana",
			"BVT" => "Bouvet Island",
			"BRA" => "Brazil",
			"IOT" => "British Indian Ocean Territory",
			"BRN" => "Brunei Darussalam",
			"BGR" => "Bulgaria",
			"BFA" => "Burkina Faso",
			"BDI" => "Burundi",
			"KHM" => "Cambodia",
			"CMR" => "Cameroon",
			"CAN" => "Canada",
			"CPV" => "Cape Verde",
			"CYM" => "Cayman Islands",
			"CAF" => "Central African Republic",
			"TCD" => "Chad",
			"CHL" => "Chile",
			"CHN" => "China",
			"CXR" => "Christmas Island",
			"CCK" => "Cocos (Keeling) Islands",
			"COL" => "Colombia",
			"COM" => "Comoros",
			"COG" => "Congo",
			"COD" => "Congo, the Democratic Republic of the",
			"COK" => "Cook Islands",
			"CRI" => "Costa Rica",
			"CIV" => "Côte d'Ivoire",
			"HRV" => "Croatia",
			"CUB" => "Cuba",
			"CUW" => "Curaçao",
			"CYP" => "Cyprus",
			"CZE" => "Czech Republic",
			"DNK" => "Denmark",
			"DJI" => "Djibouti",
			"DMA" => "Dominica",
			"DOM" => "Dominican Republic",
			"ECU" => "Ecuador",
			"EGY" => "Egypt",
			"SLV" => "El Salvador",
			"GNQ" => "Equatorial Guinea",
			"ERI" => "Eritrea",
			"EST" => "Estonia",
			"ETH" => "Ethiopia",
			"FLK" => "Falkland Islands (Malvinas)",
			"FRO" => "Faroe Islands",
			"FJI" => "Fiji",
			"FIN" => "Finland",
			"FRA" => "France",
			"GUF" => "French Guiana",
			"PYF" => "French Polynesia",
			"ATF" => "French Southern Territories",
			"GAB" => "Gabon",
			"GMB" => "Gambia",
			"GEO" => "Georgia",
			"DEU" => "Germany",
			"GHA" => "Ghana",
			"GIB" => "Gibraltar",
			"GRC" => "Greece",
			"GRL" => "Greenland",
			"GRD" => "Grenada",
			"GLP" => "Guadeloupe",
			"GUM" => "Guam",
			"GTM" => "Guatemala",
			"GGY" => "Guernsey",
			"GIN" => "Guinea",
			"GNB" => "Guinea-Bissau",
			"GUY" => "Guyana",
			"HTI" => "Haiti",
			"HMD" => "Heard Island and McDonald Islands",
			"VAT" => "Holy See (Vatican City State)",
			"HND" => "Honduras",
			"HKG" => "Hong Kong",
			"HUN" => "Hungary",
			"ISL" => "Iceland",
			"IND" => "India",
			"IDN" => "Indonesia",
			"IRN" => "Iran, Islamic Republic of",
			"IRQ" => "Iraq",
			"IRL" => "Ireland",
			"IMN" => "Isle of Man",
			"ISR" => "Israel",
			"ITA" => "Italy",
			"JAM" => "Jamaica",
			"JPN" => "Japan",
			"JEY" => "Jersey",
			"JOR" => "Jordan",
			"KAZ" => "Kazakhstan",
			"KEN" => "Kenya",
			"KIR" => "Kiribati",
			"PRK" => "Korea, Democratic People's Republic of",
			"KOR" => "Korea, Republic of",
			"KWT" => "Kuwait",
			"KGZ" => "Kyrgyzstan",
			"LAO" => "Lao People's Democratic Republic",
			"LVA" => "Latvia",
			"LBN" => "Lebanon",
			"LSO" => "Lesotho",
			"LBR" => "Liberia",
			"LBY" => "Libya",
			"LIE" => "Liechtenstein",
			"LTU" => "Lithuania",
			"LUX" => "Luxembourg",
			"MAC" => "Macao",
			"MKD" => "Macedonia, the former Yugoslav Republic of",
			"MDG" => "Madagascar",
			"MWI" => "Malawi",
			"MYS" => "Malaysia",
			"MDV" => "Maldives",
			"MLI" => "Mali",
			"MLT" => "Malta",
			"MHL" => "Marshall Islands",
			"MTQ" => "Martinique",
			"MRT" => "Mauritania",
			"MUS" => "Mauritius",
			"MYT" => "Mayotte",
			"MEX" => "Mexico",
			"FSM" => "Micronesia, Federated States of",
			"MDA" => "Moldova, Republic of",
			"MCO" => "Monaco",
			"MNG" => "Mongolia",
			"MNE" => "Montenegro",
			"MSR" => "Montserrat",
			"MAR" => "Morocco",
			"MOZ" => "Mozambique",
			"MMR" => "Myanmar",
			"NAM" => "Namibia",
			"NRU" => "Nauru",
			"NPL" => "Nepal",
			"NLD" => "Netherlands",
			"NCL" => "New Caledonia",
			"NZL" => "New Zealand",
			"NIC" => "Nicaragua",
			"NER" => "Niger",
			"NGA" => "Nigeria",
			"NIU" => "Niue",
			"NFK" => "Norfolk Island",
			"MNP" => "Northern Mariana Islands",
			"NOR" => "Norway",
			"OMN" => "Oman",
			"PAK" => "Pakistan",
			"PLW" => "Palau",
			"PSE" => "Palestinian Territory, Occupied",
			"PAN" => "Panama",
			"PNG" => "Papua New Guinea",
			"PRY" => "Paraguay",
			"PER" => "Peru",
			"PHL" => "Philippines",
			"PCN" => "Pitcairn",
			"POL" => "Poland",
			"PRT" => "Portugal",
			"PRI" => "Puerto Rico",
			"QAT" => "Qatar",
			"REU" => "Réunion",
			"ROU" => "Romania",
			"RUS" => "Russian Federation",
			"RWA" => "Rwanda",
			"BLM" => "Saint Barthélemy",
			"SHN" => "Saint Helena, Ascension and Tristan da Cunha",
			"KNA" => "Saint Kitts and Nevis",
			"LCA" => "Saint Lucia",
			"MAF" => "Saint Martin (French part)",
			"SPM" => "Saint Pierre and Miquelon",
			"VCT" => "Saint Vincent and the Grenadines",
			"WSM" => "Samoa",
			"SMR" => "San Marino",
			"STP" => "Sao Tome and Principe",
			"SAU" => "Saudi Arabia",
			"SEN" => "Senegal",
			"SRB" => "Serbia",
			"SYC" => "Seychelles",
			"SLE" => "Sierra Leone",
			"SGP" => "Singapore",
			"SXM" => "Sint Maarten (Dutch part)",
			"SVK" => "Slovakia",
			"SVN" => "Slovenia",
			"SLB" => "Solomon Islands",
			"SOM" => "Somalia",
			"ZAF" => "South Africa",
			"SGS" => "South Georgia and the South Sandwich Islands",
			"SSD" => "South Sudan",
			"ESP" => "Spain",
			"LKA" => "Sri Lanka",
			"SDN" => "Sudan",
			"SUR" => "Suriname",
			"SJM" => "Svalbard and Jan Mayen",
			"SWZ" => "Swaziland",
			"SWE" => "Sweden",
			"CHE" => "Switzerland",
			"SYR" => "Syrian Arab Republic",
			"TWN" => "Taiwan, Province of China",
			"TJK" => "Tajikistan",
			"TZA" => "Tanzania, United Republic of",
			"THA" => "Thailand",
			"TLS" => "Timor-Leste",
			"TGO" => "Togo",
			"TKL" => "Tokelau",
			"TON" => "Tonga",
			"TTO" => "Trinidad and Tobago",
			"TUN" => "Tunisia",
			"TUR" => "Turkey",
			"TKM" => "Turkmenistan",
			"TCA" => "Turks and Caicos Islands",
			"TUV" => "Tuvalu",
			"UGA" => "Uganda",
			"UKR" => "Ukraine",
			"ARE" => "United Arab Emirates",
			"GBR" => "United Kingdom",
			"USA" => "United States",
			"UMI" => "United States Minor Outlying Islands",
			"URY" => "Uruguay",
			"UZB" => "Uzbekistan",
			"VUT" => "Vanuatu",
			"VEN" => "Venezuela, Bolivarian Republic of",
			"VNM" => "Viet Nam",
			"VGB" => "Virgin Islands, British",
			"VIR" => "Virgin Islands, U.S.",
			"WLF" => "Wallis and Futuna",
			"ESH" => "Western Sahara",
			"YEM" => "Yemen",
			"ZMB" => "Zambia",
			"ZWE" => "Zimbabwe",
		);
		
		$this->pageData->data->timezones = array(
			"-12" => "(GMT-12:00) International Date Line West",
			"-11" => "(GMT-11:00) Midway Island, Samoa",
			"-10" => "(GMT-10:00) Hawaii",
			"-9" => "(GMT-09:00) Alaska",
			"-8" => "(GMT-08:00) Pacific Time (US & Canada)",
			"-8" => "(GMT-08:00) Tijuana, Baja California",
			"-7" => "(GMT-07:00) Arizona",
			"-7" => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
			"-7" => "(GMT-07:00) Mountain Time (US & Canada)",
			"-6" => "(GMT-06:00) Central America",
			"-6" => "(GMT-06:00) Central Time (US & Canada)",
			"-6" => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
			"-6" => "(GMT-06:00) Saskatchewan",
			"-5" => "(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
			"-5" => "(GMT-05:00) Eastern Time (US & Canada)",
			"-5" => "(GMT-05:00) Indiana (East)",
			"-4" => "(GMT-04:00) Atlantic Time (Canada)",
			"-4" => "(GMT-04:00) Caracas, La Paz",
			"-4" => "(GMT-04:00) Manaus",
			"-4" => "(GMT-04:00) Santiago",
			"-3.5" => "(GMT-03:30) Newfoundland",
			"-3" => "(GMT-03:00) Brasilia",
			"-3" => "(GMT-03:00) Buenos Aires, Georgetown",
			"-3" => "(GMT-03:00) Greenland",
			"-3" => "(GMT-03:00) Montevideo",
			"-2" => "(GMT-02:00) Mid-Atlantic",
			"-1" => "(GMT-01:00) Cape Verde Is.",
			"-1" => "(GMT-01:00) Azores",
			"0" => "(GMT+00:00) Casablanca, Monrovia, Reykjavik",
			"0" => "(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London",
			"1" => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
			"1" => "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
			"1" => "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
			"1" => "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
			"1" => "(GMT+01:00) West Central Africa",
			"2" => "(GMT+02:00) Amman",
			"2" => "(GMT+02:00) Athens, Bucharest, Istanbul",
			"2" => "(GMT+02:00) Beirut",
			"2" => "(GMT+02:00) Cairo",
			"2" => "(GMT+02:00) Harare, Pretoria",
			"2" => "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
			"2" => "(GMT+02:00) Jerusalem",
			"2" => "(GMT+02:00) Minsk",
			"2" => "(GMT+02:00) Windhoek",
			"3" => "(GMT+03:00) Kuwait, Riyadh, Baghdad",
			"3" => "(GMT+03:00) Moscow, St. Petersburg, Volgograd",
			"3" => "(GMT+03:00) Nairobi",
			"3" => "(GMT+03:00) Tbilisi",
			"3.5" => "(GMT+03:30) Tehran",
			"4" => "(GMT+04:00) Abu Dhabi, Muscat",
			"4" => "(GMT+04:00) Baku",
			"4" => "(GMT+04:00) Yerevan",
			"4.5" => "(GMT+04:30) Kabul",
			"5" => "(GMT+05:00) Yekaterinburg",
			"5" => "(GMT+05:00) Islamabad, Karachi, Tashkent",
			"5.5" => "(GMT+05:30) Sri Jayawardenapura",
			"5.5" => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
			"5.75" => "(GMT+05:45) Kathmandu",
			"6" => "(GMT+06:00) Almaty, Novosibirsk",
			"6" => "(GMT+06:00) Astana, Dhaka",
			"6.5" => "(GMT+06:30) Yangon (Rangoon)",
			"7" => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
			"7" => "(GMT+07:00) Krasnoyarsk",
			"8" => "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
			"8" => "(GMT+08:00) Kuala Lumpur, Singapore",
			"8" => "(GMT+08:00) Irkutsk, Ulaan Bataar",
			"8" => "(GMT+08:00) Perth",
			"8" => "(GMT+08:00) Taipei",
			"9" => "(GMT+09:00) Osaka, Sapporo, Tokyo",
			"9" => "(GMT+09:00) Seoul",
			"9" => "(GMT+09:00) Yakutsk",
			"9.5" => "(GMT+09:30) Adelaide",
			"9.5" => "(GMT+09:30) Darwin",
			"10" => "(GMT+10:00) Brisbane",
			"10" => "(GMT+10:00) Canberra, Melbourne, Sydney",
			"10" => "(GMT+10:00) Hobart",
			"10" => "(GMT+10:00) Guam, Port Moresby",
			"10" => "(GMT+10:00) Vladivostok",
			"11" => "(GMT+11:00) Magadan, Solomon Is., New Caledonia",
			"12" => "(GMT+12:00) Auckland, Wellington",
			"12" => "(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
			"13" => "(GMT+13:00) Nuku'alofa",
		);

		View::share('pageData', $this->pageData);
		View::share('warningMsg',null);
		View::share('dangerMsg',null);
		View::share('successMsg',null);
		View::share('infoMsg',null);
		View::share('linkMsg',null);
		View::share('dangerMsg',null);
		View::share('darkMsg',null);
		View::share('primaryMsg',null);
		
	}
	
	protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
	
	
}
