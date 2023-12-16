<?php
namespace JI\Utils;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Phone {
  private const PATTERNS = [
    [
      'name' => "Ascension Island",
      'prefix' => 247,
      'pattern' => "4\d{4}",
      'country_code' => "AC",
      'example' => "40123",
      'min_length' => 5,
      'max_length' => 5
    ],
    [
      'name' => "Andorra",
      'prefix' => 376,
      'pattern' => "690\d{6}|[36]\d{5}",
      'country_code' => "AD",
      'example' => "312345",
      'min_length' => 6,
      'max_length' => 9
    ],
    [
      'name' => "United Arab Emirates",
      'prefix' => 971,
      'pattern' => "5[024-68]\d{7}",
      'country_code' => "AE",
      'example' => "501234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Afghanistan",
      'prefix' => 93,
      'pattern' => "7(?:[014-9]\d|2[89]|3[01])\d{6}",
      'country_code' => "AF",
      'example' => "701234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Antigua & Barbuda",
      'prefix' => 1,
      'pattern' => "268(?:464|7(?:1[3-9]|2\d|3[246]|64|[78][0-689]))\d{4}",
      'country_code' => "AG",
      'example' => "2684641234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Anguilla",
      'prefix' => 1,
      'pattern' => "264(?:235|476|5(?:3[6-9]|8[1-4])|7(?:29|72))\d{4}",
      'country_code' => "AI",
      'example' => "2642351234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Albania",
      'prefix' => 355,
      'pattern' => "6(?:[689][2-9]|7[2-6])\d{6}",
      'country_code' => "AL",
      'example' => "662123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Armenia",
      'prefix' => 374,
      'pattern' => "(?:4[1349]|55|77|88|9[13-9])\d{6}",
      'country_code' => "AM",
      'example' => "77123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Angola",
      'prefix' => 244,
      'pattern' => "9[1-49]\d{7}",
      'country_code' => "AO",
      'example' => "923123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Argentina",
      'prefix' => 54,
      'pattern' => "675\d{7}|9(?:11[2-9]\d{7}|(?:2(?:2[013]|3[067]|49|6[01346]|80|9[147-9])|3(?:36|4[1-358]|5[138]|6[24]|7[069]|8[013578]))[2-9]\d{6}|(?:2(?:2(?:02|2[13-79]|4[1-6]|5[2457]|6[124-8]|7[1-4]|8[13-6]|9[1267])|3(?:02|1[467]|2[03-6]|3[13-8]|[49][2-6]|5[2-8])|47[3-578]|6(?:2[24-6]|4[6-8]|5[15-8])|9(?:0[1-3]|2\d|3[1-6]|4[02568]|5[2-4]|6[2-46]|72|8[23]))|3(?:3(?:2[79]|8[2578])|4(?:0[0-24-9]|4[24-7]|6[02-9]|7[126]|9[1-36-8])|5(?:2[1245]|3[237]|4[1-46-9]|6[2-4]|7[1-6]|8[2-5])|7(?:1[1568]|2[15]|3[145]|4[13]|5[14-8]|7[2-57]|8[126])|8(?:2[15-7]|3[2578]|4[13-6]|5[4-8]|6[1-357-9]|9[124])))[2-9]\d{5})",
      'country_code' => "AR",
      'example' => "91123456789",
      'min_length' => 10,
      'max_length' => 11
    ],
    [
      'name' => "American Samoa",
      'prefix' => 1,
      'pattern' => "684(?:2(?:5[2468]|72)|7(?:3[13]|70))\d{4}",
      'country_code' => "AS",
      'example' => "6847331234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Austria",
      'prefix' => 43,
      'pattern' => "6(?:5[0-3579]|6[013-9]|[7-9]\d)\d{4,10}",
      'country_code' => "AT",
      'example' => "664123456",
      'min_length' => 7,
      'max_length' => 13
    ],
    [
      'name' => "Australia",
      'prefix' => 61,
      'pattern' => "4(?:[0-3]\d|4[047-9]|5[0-25-9]|6[6-9]|7[02-9]|8[0-2457-9]|9[017-9])\d{6}",
      'country_code' => "AU",
      'example' => "412345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Aruba",
      'prefix' => 297,
      'pattern' => "(?:290|5[69]\d|6(?:[03]0|22|4[0-2]|[69]\d)|7(?:[34]\d|7[07])|9(?:6[45]|9[4-8]))\d{4}",
      'country_code' => "AW",
      'example' => "5601234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Åland Islands",
      'prefix' => 358,
      'pattern' => "(?:4[0-8]|50)\d{4,8}",
      'country_code' => "AX",
      'example' => "412345678",
      'min_length' => 6,
      'max_length' => 10
    ],
    [
      'name' => "Azerbaijan",
      'prefix' => 994,
      'pattern' => "(?:36554|(?:4[04]|5[015]|60|7[07])\d{3})\d{4}",
      'country_code' => "AZ",
      'example' => "401234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Bosnia",
      'prefix' => 387,
      'pattern' => "6(?:0(?:3\d|40)|[1-356]\d|44[0-6]|71[137])\d{5}",
      'country_code' => "BA",
      'example' => "61123456",
      'min_length' => 8,
      'max_length' => 9
    ],
    [
      'name' => "Barbados",
      'prefix' => 1,
      'pattern' => "246(?:2(?:[356]\d|4[0-57-9]|8[0-79])|45\d|69[5-7]|8(?:[2-5]\d|83))\d{4}",
      'country_code' => "BB",
      'example' => "2462501234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Bangladesh",
      'prefix' => 880,
      'pattern' => "(?:1[13-9]\d|(?:3[78]|44)[02-9]|6(?:44|6[02-9]))\d{7}",
      'country_code' => "BD",
      'example' => "1812345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Belgium",
      'prefix' => 32,
      'pattern' => "4(?:5[56]|6[0135-8]|[79]\d|8[3-9])\d{6}",
      'country_code' => "BE",
      'example' => "470123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Burkina Faso",
      'prefix' => 226,
      'pattern' => "(?:5[124-8]|[67]\d)\d{6}",
      'country_code' => "BF",
      'example' => "70123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Bulgaria",
      'prefix' => 359,
      'pattern' => "(?:4(?:3[07-9]|8\d)|(?:8[7-9]\d|9(?:8\d|9[69]))\d)\d{5}",
      'country_code' => "BG",
      'example' => "48123456",
      'min_length' => 8,
      'max_length' => 9
    ],
    [
      'name' => "Bahrain",
      'prefix' => 973,
      'pattern' => "(?:3(?:[1-4679]\d|5[013-69]|8[0-47-9])\d|6(?:3(?:00|33|6[16])|6(?:3[03-9]|[69]\d|7[0-6])))\d{4}",
      'country_code' => "BH",
      'example' => "36001234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Burundi",
      'prefix' => 257,
      'pattern' => "(?:29|31|6[189]|7[125-9])\d{6}",
      'country_code' => "BI",
      'example' => "79561234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Benin",
      'prefix' => 229,
      'pattern' => "(?:6\d|9[03-9])\d{6}",
      'country_code' => "BJ",
      'example' => "90011234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "St. Barthélemy",
      'prefix' => 590,
      'pattern' => "69(?:0\d\d|1(?:2[29]|3[0-5]))\d{4}",
      'country_code' => "BL",
      'example' => "690001234",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Bermuda",
      'prefix' => 1,
      'pattern' => "441(?:[37]\d|5[0-39])\d{5}",
      'country_code' => "BM",
      'example' => "4413701234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Brunei",
      'prefix' => 673,
      'pattern' => "(?:22[89]|[78]\d\d)\d{4}",
      'country_code' => "BN",
      'example' => "7123456",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Bolivia",
      'prefix' => 591,
      'pattern' => "[67]\d{7}",
      'country_code' => "BO",
      'example' => "71234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Caribbean Netherlands",
      'prefix' => 599,
      'pattern' => "(?:31(?:8[14-8]|9[14578])|416[14-9]|7(?:0[01]|7[07]|8\d|9[056])\d)\d{3}",
      'country_code' => "BQ",
      'example' => "3181234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Brazil",
      'prefix' => 55,
      'pattern' => "(?:[189][1-9]|2[12478])(?:7|9\d)\d{7}|(?:3[1-578]|[46][1-9]|5[13-5]|7[13-579])(?:[6-9]|9\d)\d{7}",
      'country_code' => "BR",
      'example' => "11961234567",
      'min_length' => 10,
      'max_length' => 11
    ],
    [
      'name' => "Bahamas",
      'prefix' => 1,
      'pattern' => "242(?:3(?:5[79]|7[56]|95)|4(?:[23][1-9]|4[1-35-9]|5[1-8]|6[2-8]|7\d|81)|5(?:2[45]|3[35]|44|5[1-46-9]|65|77)|6[34]6|7(?:27|38)|8(?:0[1-9]|1[02-9]|2\d|[89]9))\d{4}",
      'country_code' => "BS",
      'example' => "2423591234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Bhutan",
      'prefix' => 975,
      'pattern' => "(?:1[67]|77)\d{6}",
      'country_code' => "BT",
      'example' => "17123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Botswana",
      'prefix' => 267,
      'pattern' => "7(?:[1-6]\d{3}|7(?:[014-8]\d\d|200))\d{3}",
      'country_code' => "BW",
      'example' => "71123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Belarus",
      'prefix' => 375,
      'pattern' => "(?:2(?:5[5-79]|9[1-9])|(?:33|44)\d)\d{6}",
      'country_code' => "BY",
      'example' => "294911911",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Belize",
      'prefix' => 501,
      'pattern' => "6[0-35-7]\d{5}",
      'country_code' => "BZ",
      'example' => "6221234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Canada",
      'prefix' => 1,
      'pattern' => "(?:2(?:04|[23]6|[48]9|50)|3(?:06|43|65)|4(?:03|1[68]|3[178]|50)|5(?:06|1[49]|48|79|8[17])|6(?:04|13|39|47)|7(?:0[59]|78|8[02])|8(?:[06]7|19|25|73)|90[25])[2-9]\d{6}",
      'country_code' => "CA",
      'example' => "5062345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Cocos (Keeling) Islands",
      'prefix' => 61,
      'pattern' => "4(?:[0-3]\d|4[047-9]|5[0-25-9]|6[6-9]|7[02-9]|8[0-2457-9]|9[017-9])\d{6}",
      'country_code' => "CC",
      'example' => "412345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Congo - Kinshasa",
      'prefix' => 243,
      'pattern' => "(?:8(?:[0-2459]\d\d|8)|9[017-9]\d\d)\d{5}",
      'country_code' => "CD",
      'example' => "991234567",
      'min_length' => 7,
      'max_length' => 9
    ],
    [
      'name' => "Central African Republic",
      'prefix' => 236,
      'pattern' => "7[0257]\d{6}",
      'country_code' => "CF",
      'example' => "70012345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Congo - Brazzaville",
      'prefix' => 242,
      'pattern' => "0[14-6]\d{7}",
      'country_code' => "CG",
      'example' => "061234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Switzerland",
      'prefix' => 41,
      'pattern' => "7[35-9]\d{7}",
      'country_code' => "CH",
      'example' => "781234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Côte d’Ivoire",
      'prefix' => 225,
      'pattern' => "(?:[07][1-9]|[45]\d|6[014-9]|8[4-9])\d{6}",
      'country_code' => "CI",
      'example' => "01234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Cook Islands",
      'prefix' => 682,
      'pattern' => "[5-8]\d{4}",
      'country_code' => "CK",
      'example' => "71234",
      'min_length' => 5,
      'max_length' => 5
    ],
    [
      'name' => "Chile",
      'prefix' => 56,
      'pattern' => "(?:2(?:1962|(?:2\d\d|32[0-46-8])\d)|(?:(?:3[2-5]|[47][1-35]|5[1-3578]|6[13-57]|9[2-9])\d|8(?:0[1-9]|[1-9]\d))\d\d)\d{4}",
      'country_code' => "CL",
      'example' => "221234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Cameroon",
      'prefix' => 237,
      'pattern' => "6[5-9]\d{7}",
      'country_code' => "CM",
      'example' => "671234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "China",
      'prefix' => 86,
      'pattern' => "1(?:[38]\d{3}|4[57]\d{2}|5[0-35-9]\d{2}|6[267]\d{2}|7(?:[0-35-8]\d{2}|40[0-5])|9[189]\d{2})\d{6}",
      'country_code' => "CN",
      'example' => "13123456789",
      'min_length' => 11,
      'max_length' => 11
    ],
    [
      'name' => "Colombia",
      'prefix' => 57,
      'pattern' => "3(?:0[0-5]|1\d|2[0-3]|5[01])\d{7}",
      'country_code' => "CO",
      'example' => "3211234567",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Costa Rica",
      'prefix' => 506,
      'pattern' => "(?:(?:5(?:0[01]|7[0-3])|(?:7[0-3]|8[3-9])\d)\d\d|6(?:[0-4]\d{3}|500[01]))\d{3}",
      'country_code' => "CR",
      'example' => "83123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Cuba",
      'prefix' => 53,
      'pattern' => "5\d{7}",
      'country_code' => "CU",
      'example' => "51234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Cape Verde",
      'prefix' => 238,
      'pattern' => "(?:[34][36]|5[1-389]|9\d)\d{5}",
      'country_code' => "CV",
      'example' => "9911234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Curaçao",
      'prefix' => 599,
      'pattern' => "9(?:5(?:[12467]\d|3[01])|6(?:[15-9]\d|3[01]))\d{4}",
      'country_code' => "CW",
      'example' => "95181234",
      'min_length' => 7,
      'max_length' => 8
    ],
    [
      'name' => "Christmas Island",
      'prefix' => 61,
      'pattern' => "4(?:[0-3]\d|4[047-9]|5[0-25-9]|6[6-9]|7[02-9]|8[0-2457-9]|9[017-9])\d{6}",
      'country_code' => "CX",
      'example' => "412345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Cyprus",
      'prefix' => 357,
      'pattern' => "9[4-79]\d{6}",
      'country_code' => "CY",
      'example' => "96123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Czechia",
      'prefix' => 420,
      'pattern' => "(?:60[1-8]|7(?:0[2-5]|[2379]\d))\d{6}",
      'country_code' => "CZ",
      'example' => "601123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Germany",
      'prefix' => 49,
      'pattern' => "1(?:5[0-25-9]\d{8}|(?:6[023]|7\d)\d{7,8})",
      'country_code' => "DE",
      'example' => "15123456789",
      'min_length' => 10,
      'max_length' => 11
    ],
    [
      'name' => "Djibouti",
      'prefix' => 253,
      'pattern' => "77\d{6}",
      'country_code' => "DJ",
      'example' => "77831001",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Denmark",
      'prefix' => 45,
      'pattern' => "(?:[2-7]\d|8[126-9]|9[1-36-9])\d{6}",
      'country_code' => "DK",
      'example' => "32123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Dominica",
      'prefix' => 1,
      'pattern' => "767(?:2(?:[2-4689]5|7[5-7])|31[5-7]|61[1-7])\d{4}",
      'country_code' => "DM",
      'example' => "7672251234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Dominican Republic",
      'prefix' => 1,
      'pattern' => "8[024]9[2-9]\d{6}",
      'country_code' => "DO",
      'example' => "8092345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Algeria",
      'prefix' => 213,
      'pattern' => "(?:(?:5[4-6]|7[7-9])\d|6(?:[569]\d|7[0-6]))\d{6}",
      'country_code' => "DZ",
      'example' => "551234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Ecuador",
      'prefix' => 593,
      'pattern' => "9(?:(?:39|[57][89]|[89]\d)\d|6(?:[0-27-9]\d|30))\d{5}",
      'country_code' => "EC",
      'example' => "991234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Estonia",
      'prefix' => 372,
      'pattern' => "(?:5\d|8[1-4])\d{6}|5(?:(?:[02]\d|5[0-478])\d|1(?:[0-8]\d|95)|6(?:4[0-4]|5[1-589]))\d{3}",
      'country_code' => "EE",
      'example' => "51234567",
      'min_length' => 7,
      'max_length' => 8
    ],
    [
      'name' => "Egypt",
      'prefix' => 20,
      'pattern' => "1[0-25]\d{8}",
      'country_code' => "EG",
      'example' => "1001234567",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Western Sahara",
      'prefix' => 212,
      'pattern' => "(?:6(?:[0-79]\d|8[0-247-9])|7(?:0[067]|6[1267]|7[017]))\d{6}",
      'country_code' => "EH",
      'example' => "650123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Eritrea",
      'prefix' => 291,
      'pattern' => "(?:17[1-3]|7\d\d)\d{4}",
      'country_code' => "ER",
      'example' => "7123456",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Spain",
      'prefix' => 34,
      'pattern' => "(?:(?:6\d|7[1-48])\d{5}|9(?:6906(?:09|10)|7390\d\d))\d\d",
      'country_code' => "ES",
      'example' => "612345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Ethiopia",
      'prefix' => 251,
      'pattern' => "9\d{8}",
      'country_code' => "ET",
      'example' => "911234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Finland",
      'prefix' => 358,
      'pattern' => "(?:4[0-8]|50)\d{4,8}",
      'country_code' => "FI",
      'example' => "412345678",
      'min_length' => 6,
      'max_length' => 10
    ],
    [
      'name' => "Fiji",
      'prefix' => 679,
      'pattern' => "(?:[279]\d|45|5[01568]|8[034679])\d{5}",
      'country_code' => "FJ",
      'example' => "7012345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Falkland Islands",
      'prefix' => 500,
      'pattern' => "[56]\d{4}",
      'country_code' => "FK",
      'example' => "51234",
      'min_length' => 5,
      'max_length' => 5
    ],
    [
      'name' => "Micronesia",
      'prefix' => 691,
      'pattern' => "(?:3[2357]0[1-9]|9[2-7]\d\d)\d{3}",
      'country_code' => "FM",
      'example' => "3501234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Faroe Islands",
      'prefix' => 298,
      'pattern' => "(?:[27][1-9]|5\d)\d{4}",
      'country_code' => "FO",
      'example' => "211234",
      'min_length' => 6,
      'max_length' => 6
    ],
    [
      'name' => "France",
      'prefix' => 33,
      'pattern' => "(?:6\d\d|7(?:00|[3-9]\d))\d{6}",
      'country_code' => "FR",
      'example' => "612345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Gabon",
      'prefix' => 241,
      'pattern' => "(?:0[2-7]|[2-7])\d{6}",
      'country_code' => "GA",
      'example' => "06031234",
      'min_length' => 7,
      'max_length' => 8
    ],
    [
      'name' => "United Kingdom",
      'prefix' => 44,
      'pattern' => "7(?:(?:[1-3]\d\d|5(?:0[0-8]|[13-9]\d|2[0-35-9])|8(?:[014-9]\d|[23][0-8]))\d|4(?:[0-46-9]\d\d|5(?:[0-689]\d|7[0-57-9]))|7(?:0(?:0[01]|[1-9]\d)|(?:[1-7]\d|8[02-9]|9[0-689])\d)|9(?:(?:[024-9]\d|3[0-689])\d|1(?:[02-9]\d|1[028])))\d{5}",
      'country_code' => "GB",
      'example' => "7400123456",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Grenada",
      'prefix' => 1,
      'pattern' => "473(?:4(?:0[2-79]|1[04-9]|2[0-5]|58)|5(?:2[01]|3[3-8])|901)\d{4}",
      'country_code' => "GD",
      'example' => "4734031234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Georgia",
      'prefix' => 995,
      'pattern' => "(?:5(?:[14]4|5[0157-9]|68|7[0147-9]|9[1-35-9])|790)\d{6}",
      'country_code' => "GE",
      'example' => "555123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "French Guiana",
      'prefix' => 594,
      'pattern' => "694(?:[0-249]\d|3[0-48])\d{4}",
      'country_code' => "GF",
      'example' => "694201234",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Guernsey",
      'prefix' => 44,
      'pattern' => "7(?:(?:781|839)\d|911[17])\d{5}",
      'country_code' => "GG",
      'example' => "7781123456",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Ghana",
      'prefix' => 233,
      'pattern' => "(?:2[0346-8]\d|5(?:[0457]\d|6[01]))\d{6}",
      'country_code' => "GH",
      'example' => "231234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Gibraltar",
      'prefix' => 350,
      'pattern' => "(?:5[46-8]\d|629)\d{5}",
      'country_code' => "GI",
      'example' => "57123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Greenland",
      'prefix' => 299,
      'pattern' => "(?:[25][1-9]|4[2-9])\d{4}",
      'country_code' => "GL",
      'example' => "221234",
      'min_length' => 6,
      'max_length' => 6
    ],
    [
      'name' => "Gambia",
      'prefix' => 220,
      'pattern' => "[23679]\d{6}",
      'country_code' => "GM",
      'example' => "3012345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Guinea",
      'prefix' => 224,
      'pattern' => "6[02356]\d{7}",
      'country_code' => "GN",
      'example' => "601123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Guadeloupe",
      'prefix' => 590,
      'pattern' => "69(?:0\d\d|1(?:2[29]|3[0-5]))\d{4}",
      'country_code' => "GP",
      'example' => "690001234",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Equatorial Guinea",
      'prefix' => 240,
      'pattern' => "(?:222|55[015])\d{6}",
      'country_code' => "GQ",
      'example' => "222123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Greece",
      'prefix' => 30,
      'pattern' => "6(?:8[57-9]|9\d)\d{7}",
      'country_code' => "GR",
      'example' => "6912345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Guatemala",
      'prefix' => 502,
      'pattern' => "[3-5]\d{7}",
      'country_code' => "GT",
      'example' => "51234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Guam",
      'prefix' => 1,
      'pattern' => "671(?:3(?:00|3[39]|4[349]|55|6[26])|4(?:00|56|7[1-9]|8[0236-9])|5(?:55|6[2-5]|88)|6(?:3[2-578]|4[24-9]|5[34]|78|8[235-9])|7(?:[0479]7|2[0167]|3[45]|8[7-9])|8(?:[2-57-9]8|6[48])|9(?:2[29]|6[79]|7[1279]|8[7-9]|9[78]))\d{4}",
      'country_code' => "GU",
      'example' => "6713001234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Guinea-Bissau",
      'prefix' => 245,
      'pattern' => "9(?:5\d|6[569]|77)\d{6}",
      'country_code' => "GW",
      'example' => "955012345",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Guyana",
      'prefix' => 592,
      'pattern' => "6\d{6}",
      'country_code' => "GY",
      'example' => "6091234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Hong Kong",
      'prefix' => 852,
      'pattern' => "(?:46(?:0[0-6]|10|4[0-57-9])|5(?:(?:[1-59][0-46-9]|6[0-4689])\d|7(?:[0-2469]\d|30))|6(?:(?:0[1-9]|[13-59]\d|[68][0-57-9]|7[0-79])\d|2(?:[0-57-9]\d|6[01]))|707[1-5]|8480|9(?:(?:0[1-9]|1[02-9]|[358][0-8]|[467]\d)\d|2(?:[0-8]\d|9[03-9])))\d{4}",
      'country_code' => "HK",
      'example' => "51234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Honduras",
      'prefix' => 504,
      'pattern' => "[37-9]\d{7}",
      'country_code' => "HN",
      'example' => "91234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Croatia",
      'prefix' => 385,
      'pattern' => "9(?:(?:01|[12589]\d)\d|7(?:[0679]\d|51))\d{5}|98\d{6}",
      'country_code' => "HR",
      'example' => "921234567",
      'min_length' => 8,
      'max_length' => 9
    ],
    [
      'name' => "Haiti",
      'prefix' => 509,
      'pattern' => "[34]\d{7}",
      'country_code' => "HT",
      'example' => "34101234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Hungary",
      'prefix' => 36,
      'pattern' => "(?:[257]0|3[01])\d{7}",
      'country_code' => "HU",
      'example' => "201234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Indonesia",
      'prefix' => 62,
      'pattern' => "8[1-35-9]\d{7,10}",
      'country_code' => "ID",
      'example' => "812345678",
      'min_length' => 9,
      'max_length' => 12
    ],
    [
      'name' => "Ireland",
      'prefix' => 353,
      'pattern' => "8(?:22|[35-9]\d)\d{6}",
      'country_code' => "IE",
      'example' => "850123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Israel",
      'prefix' => 972,
      'pattern' => "5(?:(?:[0-489][2-9]|6\d)\d|5(?:01|2[2-5]|3[23]|4[45]|5[05689]|6[6-8]|7[0-267]|8[7-9]|9[1-9]))\d{5}",
      'country_code' => "IL",
      'example' => "502345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Isle of Man",
      'prefix' => 44,
      'pattern' => "7(?:4576|[59]24\d|624[0-4689])\d{5}",
      'country_code' => "IM",
      'example' => "7924123456",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "India",
      'prefix' => 91,
      'pattern' => "(?:6(?:(?:0(?:0[0-3569]|26|33)|2(?:[06]\d|3[02589]|8[0-479]|9[0-79])|9(?:0[019]|13))\d|1279|3(?:(?:0[0-79]|6[0-4679]|7[0-24-9]|[89]\d)\d|5(?:0[0-6]|[1-9]\d)))|7(?:(?:0\d\d|19[0-5])\d|2(?:(?:[0235-79]\d|[14][017-9])\d|8(?:[0-59]\d|[6-8][089]))|3(?:(?:[05-8]\d|3[017-9])\d|1(?:[089]\d|11|7[02-8])|2(?:[0-49][089]|[5-8]\d)|4(?:[07-9]\d|11)|9(?:[016-9]\d|[2-5][089]))|4(?:0\d\d|1(?:[015-9]\d|[2-4][089])|[29](?:[0-7][089]|[89]\d)|3(?:[0-8][089]|9\d)|[47](?:[089]\d|11|7[02-8])|[56]\d[089]|8(?:[0-24-7][089]|[389]\d))|5(?:(?:[0346-8]\d|5[017-9])\d|1(?:[07-9]\d|11)|2(?:[04-9]\d|[1-3][089])|9(?:[0-6][089]|[7-9]\d))|6(?:0(?:[0-47]\d|[5689][089])|(?:1[0-257-9]|[6-9]\d)\d|2(?:[0-4]\d|[5-9][089])|3(?:[02-8][089]|[19]\d)|4\d[089]|5(?:[0-367][089]|[4589]\d))|7(?:0(?:0[02-9]|[13-7][089]|[289]\d)|[1-9]\d\d)|8(?:[0-79]\d\d|8(?:[089]\d|11|7[02-9]))|9(?:[089]\d\d|313|7(?:[02-8]\d|9[07-9])))|8(?:0(?:(?:[01589]\d|6[67])\d|7(?:[02-8]\d|9[04-9]))|1(?:[0-57-9]\d\d|6(?:[089]\d|7[02-8]))|2(?:[014](?:[089]\d|7[02-8])|[235-9]\d\d)|3(?:[03-57-9]\d\d|[126](?:[089]\d|7[02-8]))|[45]\d{3}|6(?:[02457-9]\d\d|[136](?:[089]\d|7[02-8]))|7(?:(?:0[07-9]|[1-69]\d)\d|[78](?:[089]\d|7[02-8]))|8(?:[0-25-9]\d\d|3(?:[089]\d|7[02-8])|4(?:[0489]\d|7[02-8]))|9(?:[02-9]\d\d|1(?:[0289]\d|7[02-8])))|9\d{4})\d{5}",
      'country_code' => "IN",
      'example' => "8123456789",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "British Indian Ocean Territory",
      'prefix' => 246,
      'pattern' => "38\d{5}",
      'country_code' => "IO",
      'example' => "3801234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Iraq",
      'prefix' => 964,
      'pattern' => "7[3-9]\d{8}",
      'country_code' => "IQ",
      'example' => "7912345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Iran",
      'prefix' => 98,
      'pattern' => "9(?:(?:0(?:[1-35]\d|44)|(?:[13]\d|2[0-2])\d)\d|9(?:(?:[01]\d|44)\d|510|8(?:1[01]|88)|9(?:0[013]|1[0134]|21|77|9[6-9])))\d{5}",
      'country_code' => "IR",
      'example' => "9123456789",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Iceland",
      'prefix' => 354,
      'pattern' => "(?:38[589]\d\d|6(?:1[1-8]|2[0-6]|3[027-9]|4[014679]|5[0159]|6[0-69]|70|8[06-8]|9\d)|7(?:5[057]|[6-8]\d|9[0-3])|8(?:2[0-59]|[3469]\d|5[1-9]|8[28]))\d{4}",
      'country_code' => "IS",
      'example' => "6111234",
      'min_length' => 7,
      'max_length' => 9
    ],
    [
      'name' => "Italy",
      'prefix' => 39,
      'pattern' => "33\d{9}|3[1-9]\d{8}|3[2-9]\d{7}",
      'country_code' => "IT",
      'example' => "3123456789",
      'min_length' => 9,
      'max_length' => 11
    ],
    [
      'name' => "Jersey",
      'prefix' => 44,
      'pattern' => "7(?:(?:(?:50|82)9|937)\d|7(?:00[378]|97[7-9]))\d{5}",
      'country_code' => "JE",
      'example' => "7797712345",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Jamaica",
      'prefix' => 1,
      'pattern' => "876(?:(?:2[14-9]|[348]\d)\d|5(?:0[3-9]|[2-57-9]\d|6[0-24-9])|7(?:0[07]|7\d|8[1-47-9]|9[0-36-9])|9(?:[01]9|9[0579]))\d{4}",
      'country_code' => "JM",
      'example' => "8762101234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Jordan",
      'prefix' => 962,
      'pattern' => "7(?:55[0-49]|(?:7[025-9]|[89][0-25-9])\d)\d{5}",
      'country_code' => "JO",
      'example' => "790123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Japan",
      'prefix' => 81,
      'pattern' => "[7-9]0[1-9]\d{7}",
      'country_code' => "JP",
      'example' => "9012345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Kenya",
      'prefix' => 254,
      'pattern' => "7\d{8}",
      'country_code' => "KE",
      'example' => "712123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Kyrgyzstan",
      'prefix' => 996,
      'pattern' => "(?:2(?:0[0-35]|2\d)|5[0-24-7]\d|7(?:[07]\d|55)|99[69])\d{6}",
      'country_code' => "KG",
      'example' => "700123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Cambodia",
      'prefix' => 855,
      'pattern' => "(?:(?:(?:1[28]|9[67])\d|8(?:[013-79]|8\d))\d|(?:2[3-6]|4[2-4]|[56][2-5])48|3(?:[18]\d\d|[2-6]48)|7(?:(?:[07-9]|[16]\d)\d|[2-5]48))\d{5}|(?:1\d|6[016-9]|9[0-57-9])\d{6}",
      'country_code' => "KH",
      'example' => "91234567",
      'min_length' => 8,
      'max_length' => 9
    ],
    [
      'name' => "Kiribati",
      'prefix' => 686,
      'pattern' => "(?:6(?:200[01]|30[01]\d)|7(?:200[01]|3(?:0[0-5]\d|140)))\d{3}",
      'country_code' => "KI",
      'example' => "72001234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Comoros",
      'prefix' => 269,
      'pattern' => "[34]\d{6}",
      'country_code' => "KM",
      'example' => "3212345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "St. Kitts & Nevis",
      'prefix' => 1,
      'pattern' => "869(?:5(?:5[6-8]|6[5-7])|66\d|76[02-7])\d{4}",
      'country_code' => "KN",
      'example' => "8697652917",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "North Korea",
      'prefix' => 850,
      'pattern' => "19[1-3]\d{7}",
      'country_code' => "KP",
      'example' => "1921234567",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "South Korea",
      'prefix' => 82,
      'pattern' => "1[0-26-9]\d{7,8}",
      'country_code' => "KR",
      'example' => "1000000000",
      'min_length' => 9,
      'max_length' => 10
    ],
    [
      'name' => "Kuwait",
      'prefix' => 965,
      'pattern' => "(?:5(?:(?:[05]\d|1[0-7]|6[56])\d|2(?:22|5[25]))|6(?:(?:0[034679]|5[015-9]|6\d)\d|222|7(?:0[013-9]|[67]\d)|9(?:[069]\d|3[039]))|9(?:(?:0[09]|22|4[01479]|55|6[0679]|8[057-9]|9\d)\d|11[01]|7(?:02|[1-9]\d)))\d{4}",
      'country_code' => "KW",
      'example' => "50012345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Cayman Islands",
      'prefix' => 1,
      'pattern' => "345(?:32[1-9]|5(?:1[67]|2[5-79]|4[6-9]|50|76)|649|9(?:1[67]|2[2-9]|3[689]))\d{4}",
      'country_code' => "KY",
      'example' => "3453231234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Kazakhstan",
      'prefix' => 7,
      'pattern' => "7(?:0[0-2578]|47|6[02-4]|7[15-8]|85)\d{7}",
      'country_code' => "KZ",
      'example' => "7710009998",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Laos",
      'prefix' => 856,
      'pattern' => "20(?:2[2389]|5[24-689]|7[6-8]|9[1-35-9])\d{6}",
      'country_code' => "LA",
      'example' => "2023123456",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Lebanon",
      'prefix' => 961,
      'pattern' => "(?:(?:3|81)\d|7(?:[01]\d|6[013-9]|8[89]|9[1-3]))\d{5}",
      'country_code' => "LB",
      'example' => "71123456",
      'min_length' => 7,
      'max_length' => 8
    ],
    [
      'name' => "St. Lucia",
      'prefix' => 1,
      'pattern' => "758(?:28[4-7]|384|4(?:6[01]|8[4-9])|5(?:1[89]|20|84)|7(?:1[2-9]|2\d|3[01]))\d{4}",
      'country_code' => "LC",
      'example' => "7582845678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Liechtenstein",
      'prefix' => 423,
      'pattern' => "(?:6(?:5(?:09|1\d|20)|6(?:0[0-6]|10|2[06-9]|39))\d|7(?:[37-9]\d|42|56))\d{4}",
      'country_code' => "LI",
      'example' => "660234567",
      'min_length' => 7,
      'max_length' => 9
    ],
    [
      'name' => "Sri Lanka",
      'prefix' => 94,
      'pattern' => "7[0-25-8]\d{7}",
      'country_code' => "LK",
      'example' => "712345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Liberia",
      'prefix' => 231,
      'pattern' => "(?:(?:(?:20|77|88)\d|330|555)\d|4[67])\d{5}|5\d{6}",
      'country_code' => "LR",
      'example' => "770123456",
      'min_length' => 7,
      'max_length' => 9
    ],
    [
      'name' => "Lesotho",
      'prefix' => 266,
      'pattern' => "[56]\d{7}",
      'country_code' => "LS",
      'example' => "50123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Lithuania",
      'prefix' => 370,
      'pattern' => "6\d{7}",
      'country_code' => "LT",
      'example' => "61234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Luxembourg",
      'prefix' => 352,
      'pattern' => "6(?:[269][18]|5[158]|7[189]|81)\d{6}",
      'country_code' => "LU",
      'example' => "628123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Latvia",
      'prefix' => 371,
      'pattern' => "2\d{7}",
      'country_code' => "LV",
      'example' => "21234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Libya",
      'prefix' => 218,
      'pattern' => "9[1-6]\d{7}",
      'country_code' => "LY",
      'example' => "912345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Morocco",
      'prefix' => 212,
      'pattern' => "(?:6(?:[0-79]\d|8[0-247-9])|7(?:0[067]|6[1267]|7[017]))\d{6}",
      'country_code' => "MA",
      'example' => "650123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Monaco",
      'prefix' => 377,
      'pattern' => "(?:(?:3|6\d)\d\d|4(?:4\d|5[1-9]))\d{5}",
      'country_code' => "MC",
      'example' => "612345678",
      'min_length' => 8,
      'max_length' => 9
    ],
    [
      'name' => "Moldova",
      'prefix' => 373,
      'pattern' => "(?:562|6\d\d|7(?:[189]\d|6[07]|7[457-9]))\d{5}",
      'country_code' => "MD",
      'example' => "62112345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Montenegro",
      'prefix' => 382,
      'pattern' => "6(?:00|3[024]|6[0-25]|[7-9]\d)\d{5}",
      'country_code' => "ME",
      'example' => "67622901",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "St. Martin",
      'prefix' => 590,
      'pattern' => "69(?:0\d\d|1(?:2[29]|3[0-5]))\d{4}",
      'country_code' => "MF",
      'example' => "690001234",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Madagascar",
      'prefix' => 261,
      'pattern' => "3[2-49]\d{7}",
      'country_code' => "MG",
      'example' => "321234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Marshall Islands",
      'prefix' => 692,
      'pattern' => "(?:(?:23|54)5|329|45[56])\d{4}",
      'country_code' => "MH",
      'example' => "2351234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "North Macedonia",
      'prefix' => 389,
      'pattern' => "7(?:(?:[0-25-8]\d|3[2-4]|9[23])\d|421)\d{4}",
      'country_code' => "MK",
      'example' => "72345678",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Mali",
      'prefix' => 223,
      'pattern' => "(?:2(?:079|17\d)|(?:50|[679]\d|8[239])\d\d)\d{4}",
      'country_code' => "ML",
      'example' => "65012345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Myanmar",
      'prefix' => 95,
      'pattern' => "(?:17[01]|9(?:2(?:[0-4]|(?:5\d|6[0-5])\d)|(?:3(?:[0-36]|4[069])|[68]9\d|7(?:3|5[0-2]|[6-9]\d))\d|4(?:(?:0[0-4]|[1379]|[25]\d|4[0-589])\d|88)|5[0-6]|9(?:[089]|[5-7]\d\d))\d)\d{4}|9[69]1\d{6}|9[68]\d{6}",
      'country_code' => "MM",
      'example' => "92123456",
      'min_length' => 7,
      'max_length' => 10
    ],
    [
      'name' => "Mongolia",
      'prefix' => 976,
      'pattern' => "(?:8(?:[05689]\d|3[01])|9[013-9]\d)\d{5}",
      'country_code' => "MN",
      'example' => "88123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Macau",
      'prefix' => 853,
      'pattern' => "6(?:[2356]\d\d|8(?:[02][5-9]|[1478]\d|[356][0-4]))\d{4}",
      'country_code' => "MO",
      'example' => "66123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Northern Mariana Islands",
      'prefix' => 1,
      'pattern' => "670(?:2(?:3[3-7]|56|8[5-8])|32[1-38]|4(?:33|8[348])|5(?:32|55|88)|6(?:64|70|82)|78[3589]|8[3-9]8|989)\d{4}",
      'country_code' => "MP",
      'example' => "6702345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Martinique",
      'prefix' => 596,
      'pattern' => "69(?:6(?:[0-47-9]\d|5[0-6]|6[0-4])|727)\d{4}",
      'country_code' => "MQ",
      'example' => "696201234",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Mauritania",
      'prefix' => 222,
      'pattern' => "[2-4][0-46-9]\d{6}",
      'country_code' => "MR",
      'example' => "22123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Montserrat",
      'prefix' => 1,
      'pattern' => "66449[2-6]\d{4}",
      'country_code' => "MS",
      'example' => "6644923456",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Malta",
      'prefix' => 356,
      'pattern' => "(?:7(?:210|[79]\d\d)|9(?:2(?:1[01]|31)|69[67]|8(?:1[1-3]|89|97)|9\d\d))\d{4}",
      'country_code' => "MT",
      'example' => "96961234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Mauritius",
      'prefix' => 230,
      'pattern' => "5(?:(?:2[589]|7\d|9[0-8])\d|4(?:2[1-389]|[489]\d|7[1-9])|8(?:[0-689]\d|7[15-8]))\d{4}",
      'country_code' => "MU",
      'example' => "52512345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Maldives",
      'prefix' => 960,
      'pattern' => "(?:46[46]|(?:7[2-9]|9[14-9])\d)\d{4}",
      'country_code' => "MV",
      'example' => "7712345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Malawi",
      'prefix' => 265,
      'pattern' => "(?:111|(?:77|88|99)\d)\d{6}",
      'country_code' => "MW",
      'example' => "991234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Mexico",
      'prefix' => 52,
      'pattern' => "1(?:2(?:2[1-9]|3[1-35-8]|4[13-9]|7[1-689]|8[1-578]|9[467])|3(?:1[1-79]|[2458][1-9]|3\d|7[1-8]|9[1-5])|4(?:1[1-57-9]|[24-7][1-9]|3[1-8]|8[1-35-9]|9[2-689])|5(?:[56]\d|88|9[1-79])|6(?:1[2-68]|[2-4][1-9]|5[1-3689]|6[1-57-9]|7[1-7]|8[67]|9[4-8])|7(?:[1-467][1-9]|5[13-9]|8[1-69]|9[17])|8(?:1\d|2[13-689]|3[1-6]|4[124-6]|6[1246-9]|7[1-378]|9[12479])|9(?:1[346-9]|2[1-4]|3[2-46-8]|5[1348]|[69][1-9]|7[12]|8[1-8]))\d{7}",
      'country_code' => "MX",
      'example' => "12221234567",
      'min_length' => 11,
      'max_length' => 11
    ],
    [
      'name' => "Malaysia",
      'prefix' => 60,
      'pattern' => "1(?:(?:0(?:[23568]\d|4[0-6]|7[016-9]|9[0-8])|1(?:[1-5]\d\d|6(?:0[5-9]|[1-9]\d))|(?:[23679][2-9]|59\d)\d)\d|4(?:[235-9]\d\d|400)|8(?:(?:1[23]|[236]\d|5[7-9]|7[016-9]|9[0-8])\d|4(?:[06]\d|7[0-4])|8(?:[01]\d|[27][0-4])))\d{4}",
      'country_code' => "MY",
      'example' => "123456789",
      'min_length' => 9,
      'max_length' => 10
    ],
    [
      'name' => "Mozambique",
      'prefix' => 258,
      'pattern' => "8[2-7]\d{7}",
      'country_code' => "MZ",
      'example' => "821234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Namibia",
      'prefix' => 264,
      'pattern' => "(?:60|8[1245])\d{7}",
      'country_code' => "NA",
      'example' => "811234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "New Caledonia",
      'prefix' => 687,
      'pattern' => "(?:5[0-4]|[79]\d|8[0-79])\d{4}",
      'country_code' => "NC",
      'example' => "751234",
      'min_length' => 6,
      'max_length' => 6
    ],
    [
      'name' => "Niger",
      'prefix' => 227,
      'pattern' => "(?:8[04589]|9\d)\d{6}",
      'country_code' => "NE",
      'example' => "93123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Norfolk Island",
      'prefix' => 672,
      'pattern' => "3[58]\d{4}",
      'country_code' => "NF",
      'example' => "381234",
      'min_length' => 6,
      'max_length' => 6
    ],
    [
      'name' => "Nigeria",
      'prefix' => 234,
      'pattern' => "(?:1(?:(?:7[34]|95)\d|8(?:04|[124579]\d|8[0-3]))|287[0-7]|3(?:18[1-8]|88[0-7]|9(?:6[1-5]|8[5-9]))|4(?:[28]8[0-2]|6(?:7[1-9]|8[02-47]))|5(?:2(?:7[7-9]|8\d)|38[1-79]|48[0-7]|68[4-7])|6(?:2(?:7[7-9]|8\d)|4(?:3[7-9]|[68][129]|7[04-69]|9[1-8])|58[0-2]|98[7-9])|7(?:0(?:[1-689]\d|7[0-3])\d\d|38[0-7]|69[1-8]|78[2-4])|8(?:(?:0(?:1[01]|[2-9]\d)|1(?:[0-8]\d|9[01]))\d\d|28[3-9]|38[0-2]|4(?:2[12]|3[147-9]|5[346]|7[4-9]|8[014-689]|90)|58[1-8]|78[2-9]|88[5-7])|9(?:0[235-9]\d\d|8[07])\d)\d{4}",
      'country_code' => "NG",
      'example' => "8021234567",
      'min_length' => 8,
      'max_length' => 10
    ],
    [
      'name' => "Nicaragua",
      'prefix' => 505,
      'pattern' => "(?:5(?:5[0-7]|[78]\d)|6(?:20|3[035]|4[045]|5[05]|77|8[1-9]|9[059])|(?:7[5-8]|8\d)\d)\d{5}",
      'country_code' => "NI",
      'example' => "81234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Netherlands",
      'prefix' => 31,
      'pattern' => "6[1-58]\d{7}",
      'country_code' => "NL",
      'example' => "612345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Norway",
      'prefix' => 47,
      'pattern' => "(?:4[015-8]|5[89]|9\d)\d{6}",
      'country_code' => "NO",
      'example' => "40612345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Nepal",
      'prefix' => 977,
      'pattern' => "9(?:6[0-3]|7[245]|8[0-24-68])\d{7}",
      'country_code' => "NP",
      'example' => "9841234567",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Nauru",
      'prefix' => 674,
      'pattern' => "55[4-9]\d{4}",
      'country_code' => "NR",
      'example' => "5551234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Niue",
      'prefix' => 683,
      'pattern' => "888[4-9]\d{3}",
      'country_code' => "NU",
      'example' => "8884012",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "New Zealand",
      'prefix' => 64,
      'pattern' => "2(?:[0-28]\d?|[79])\d{7}|21\d{6}",
      'country_code' => "NZ",
      'example' => "211234567",
      'min_length' => 8,
      'max_length' => 10
    ],
    [
      'name' => "Oman",
      'prefix' => 968,
      'pattern' => "(?:7[129]\d|9(?:0[1-9]|[1-9]\d))\d{5}",
      'country_code' => "OM",
      'example' => "92123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Panama",
      'prefix' => 507,
      'pattern' => "(?:1[16]1|21[89]|6(?:[02-9]\d|1[0-5])\d|8(?:1[01]|7[23]))\d{4}",
      'country_code' => "PA",
      'example' => "61234567",
      'min_length' => 7,
      'max_length' => 8
    ],
    [
      'name' => "Peru",
      'prefix' => 51,
      'pattern' => "9\d{8}",
      'country_code' => "PE",
      'example' => "912345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "French Polynesia",
      'prefix' => 689,
      'pattern' => "8[79]\d{6}",
      'country_code' => "PF",
      'example' => "87123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Papua New Guinea",
      'prefix' => 675,
      'pattern' => "(?:7(?:[0-689]\d|75)|81\d)\d{5}",
      'country_code' => "PG",
      'example' => "70123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Philippines",
      'prefix' => 63,
      'pattern' => "(?:81[37]|9(?:0[5-9]|1[024-9]|2[0-35-9]|3[02-9]|4[235-9]|5[056]|6[5-7]|7[3-79]|89|9[4-9]))\d{7}",
      'country_code' => "PH",
      'example' => "9051234567",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Pakistan",
      'prefix' => 92,
      'pattern' => "3(?:[014]\d|2[0-5]|3[0-7]|55|64)\d{7}",
      'country_code' => "PK",
      'example' => "3012345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Poland",
      'prefix' => 48,
      'pattern' => "(?:45|5[0137]|6[069]|7[2389]|88)\d{7}",
      'country_code' => "PL",
      'example' => "512345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "St. Pierre & Miquelon",
      'prefix' => 508,
      'pattern' => "(?:4[02-4]|5[05])\d{4}",
      'country_code' => "PM",
      'example' => "551234",
      'min_length' => 6,
      'max_length' => 6
    ],
    [
      'name' => "Puerto Rico",
      'prefix' => 1,
      'pattern' => "(?:787|939)[2-9]\d{6}",
      'country_code' => "PR",
      'example' => "7872345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Palestine",
      'prefix' => 970,
      'pattern' => "5[69]\d{7}",
      'country_code' => "PS",
      'example' => "599123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Portugal",
      'prefix' => 351,
      'pattern' => "9(?:[1-36]\d\d|480)\d{5}",
      'country_code' => "PT",
      'example' => "912345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Palau",
      'prefix' => 680,
      'pattern' => "(?:6[2-4689]0|77\d|88[0-4])\d{4}",
      'country_code' => "PW",
      'example' => "6201234",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Paraguay",
      'prefix' => 595,
      'pattern' => "9(?:51|6[129]|[78][1-6]|9[1-5])\d{6}",
      'country_code' => "PY",
      'example' => "961456789",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Qatar",
      'prefix' => 974,
      'pattern' => "[35-7]\d{7}",
      'country_code' => "QA",
      'example' => "33123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Réunion",
      'prefix' => 262,
      'pattern' => "69(?:2\d\d|3(?:0[0-46]|1[013]|2[0-2]|3[0-39]|4\d|5[05]|6[0-26]|7[0-27]|8[0-38]|9[0-479]))\d{4}",
      'country_code' => "RE",
      'example' => "692123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Romania",
      'prefix' => 40,
      'pattern' => "7(?:(?:[02-7]\d|8[03-8]|99)\d|1(?:[01]\d|20))\d{5}",
      'country_code' => "RO",
      'example' => "712034567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Serbia",
      'prefix' => 381,
      'pattern' => "6(?:[0-689]|7\d)\d{6,7}",
      'country_code' => "RS",
      'example' => "601234567",
      'min_length' => 8,
      'max_length' => 10
    ],
    [
      'name' => "Russia",
      'prefix' => 7,
      'pattern' => "9\d{9}",
      'country_code' => "RU",
      'example' => "9123456789",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Rwanda",
      'prefix' => 250,
      'pattern' => "7[238]\d{7}",
      'country_code' => "RW",
      'example' => "720123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Saudi Arabia",
      'prefix' => 966,
      'pattern' => "5(?:[013-689]\d|7[0-36-8])\d{6}",
      'country_code' => "SA",
      'example' => "512345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Solomon Islands",
      'prefix' => 677,
      'pattern' => "(?:48|(?:(?:7[1-9]|8[4-9])\d|9(?:1[2-9]|2[013-9]|3[0-2]|[46]\d|5[0-46-9]|7[0-689]|8[0-79]|9[0-8]))\d)\d{3}",
      'country_code' => "SB",
      'example' => "7421234",
      'min_length' => 5,
      'max_length' => 7
    ],
    [
      'name' => "Seychelles",
      'prefix' => 248,
      'pattern' => "2[5-8]\d{5}",
      'country_code' => "SC",
      'example' => "2510123",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Sudan",
      'prefix' => 249,
      'pattern' => "(?:1[0-2]|9[0-3569])\d{7}",
      'country_code' => "SD",
      'example' => "911231234",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Sweden",
      'prefix' => 46,
      'pattern' => "7[02369]\d{7}",
      'country_code' => "SE",
      'example' => "701234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Singapore",
      'prefix' => 65,
      'pattern' => "(?:8[1-8]|9[0-8])\d{6}",
      'country_code' => "SG",
      'example' => "81234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "St. Helena",
      'prefix' => 290,
      'pattern' => "[56]\d{4}",
      'country_code' => "SH",
      'example' => "51234",
      'min_length' => 5,
      'max_length' => 5
    ],
    [
      'name' => "Slovenia",
      'prefix' => 386,
      'pattern' => "(?:(?:[37][01]|4[0139]|51)\d\d|6(?:[48]\d\d|5(?:1\d|55|[67]0)|9(?:10|[69]\d)))\d{4}",
      'country_code' => "SI",
      'example' => "31234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Svalbard & Jan Mayen",
      'prefix' => 47,
      'pattern' => "(?:4[015-8]|5[89]|9\d)\d{6}",
      'country_code' => "SJ",
      'example' => "41234567",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Slovakia",
      'prefix' => 421,
      'pattern' => "9(?:0(?:[1-8]\d|9[1-9])|(?:1[0-24-9]|[45]\d)\d)\d{5}",
      'country_code' => "SK",
      'example' => "912123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Sierra Leone",
      'prefix' => 232,
      'pattern' => "(?:2[15]|3[013-5]|4[04]|5[05]|66|7[5-9]|8[08]|99)\d{6}",
      'country_code' => "SL",
      'example' => "25123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "San Marino",
      'prefix' => 378,
      'pattern' => "6[16]\d{6}",
      'country_code' => "SM",
      'example' => "66661212",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Senegal",
      'prefix' => 221,
      'pattern' => "7(?:[06-8]\d|21|90)\d{6}",
      'country_code' => "SN",
      'example' => "701234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Somalia",
      'prefix' => 252,
      'pattern' => "(?:(?:15|(?:3[59]|4[89]|6[1-9]|79|8[08])\d|9(?:0[67]|[2-9]))\d|2(?:4\d|8))\d{5}|(?:6\d|7[1-9])\d{6}",
      'country_code' => "SO",
      'example' => "71123456",
      'min_length' => 7,
      'max_length' => 9
    ],
    [
      'name' => "Suriname",
      'prefix' => 597,
      'pattern' => "(?:7[124-7]|8[125-9])\d{5}",
      'country_code' => "SR",
      'example' => "7412345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "South Sudan",
      'prefix' => 211,
      'pattern' => "(?:12|9[1257])\d{7}",
      'country_code' => "SS",
      'example' => "977123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "São Tomé & Príncipe",
      'prefix' => 239,
      'pattern' => "9(?:0(?:0[5-9]|[1-9]\d)|[89]\d\d)\d{3}",
      'country_code' => "ST",
      'example' => "9812345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "El Salvador",
      'prefix' => 503,
      'pattern' => "[67]\d{7}",
      'country_code' => "SV",
      'example' => "70123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Sint Maarten",
      'prefix' => 1,
      'pattern' => "7215(?:1[02]|2\d|5[034679]|8[014-8])\d{4}",
      'country_code' => "SX",
      'example' => "7215205678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Syria",
      'prefix' => 963,
      'pattern' => "9(?:22|[3-589]\d|6[024-9])\d{6}",
      'country_code' => "SY",
      'example' => "944567890",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Eswatini",
      'prefix' => 268,
      'pattern' => "7[6-9]\d{6}",
      'country_code' => "SZ",
      'example' => "76123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Turks & Caicos Islands",
      'prefix' => 1,
      'pattern' => "649(?:2(?:3[129]|4[1-7])|3(?:3[1-389]|4[1-8])|4[34][1-3])\d{4}",
      'country_code' => "TC",
      'example' => "6492311234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Chad",
      'prefix' => 235,
      'pattern' => "(?:6[023568]|77|9\d)\d{6}",
      'country_code' => "TD",
      'example' => "63012345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Togo",
      'prefix' => 228,
      'pattern' => "(?:7[09]|9[0-36-9])\d{6}",
      'country_code' => "TG",
      'example' => "90112345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Thailand",
      'prefix' => 66,
      'pattern' => "(?:14|6[1-6]|[89]\d)\d{7}",
      'country_code' => "TH",
      'example' => "812345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Tajikistan",
      'prefix' => 992,
      'pattern' => "(?:41[18]|(?:5[05]|77|88|9[0-35-9])\d)\d{6}",
      'country_code' => "TJ",
      'example' => "917123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Tokelau",
      'prefix' => 690,
      'pattern' => "7[2-4]\d{2,5}",
      'country_code' => "TK",
      'example' => "7290",
      'min_length' => 4,
      'max_length' => 7
    ],
    [
      'name' => "Timor-Leste",
      'prefix' => 670,
      'pattern' => "7[3-8]\d{6}",
      'country_code' => "TL",
      'example' => "77212345",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Turkmenistan",
      'prefix' => 993,
      'pattern' => "6[1-9]\d{6}",
      'country_code' => "TM",
      'example' => "66123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Tunisia",
      'prefix' => 216,
      'pattern' => "(?:(?:[259]\d|4[0-6])\d\d|3(?:001|1(?:[1-35]\d|40)|240|(?:6[0-4]|91)\d))\d{4}",
      'country_code' => "TN",
      'example' => "20123456",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Tonga",
      'prefix' => 676,
      'pattern' => "(?:7[578]|8[46-9])\d{5}",
      'country_code' => "TO",
      'example' => "7715123",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Turkey",
      'prefix' => 90,
      'pattern' => "5(?:(?:0[15-7]|1[06]|24|[34]\d|5[1-59]|9[46])\d\d|6161)\d{5}",
      'country_code' => "TR",
      'example' => "5012345678",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Trinidad & Tobago",
      'prefix' => 1,
      'pattern' => "868(?:2(?:6[6-9]|[7-9]\d)|[37](?:0[1-9]|1[02-9]|[2-9]\d)|4[6-9]\d|6(?:20|78|8\d))\d{4}",
      'country_code' => "TT",
      'example' => "8682911234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Tuvalu",
      'prefix' => 688,
      'pattern' => "(?:7[01]\d|90)\d{4}",
      'country_code' => "TV",
      'example' => "901234",
      'min_length' => 6,
      'max_length' => 7
    ],
    [
      'name' => "Taiwan",
      'prefix' => 886,
      'pattern' => "9[0-8]\d{7}",
      'country_code' => "TW",
      'example' => "912345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Tanzania",
      'prefix' => 255,
      'pattern' => "(?:6[2-9]|7[13-9])\d{7}",
      'country_code' => "TZ",
      'example' => "621234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Ukraine",
      'prefix' => 380,
      'pattern' => "(?:39|50|6[36-8]|7[1-3]|9[1-9])\d{7}",
      'country_code' => "UA",
      'example' => "391234567",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Uganda",
      'prefix' => 256,
      'pattern' => "7(?:(?:[0157-9]\d|30|4[0-4])\d|2(?:[03]\d|60))\d{5}",
      'country_code' => "UG",
      'example' => "712345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "United States",
      'prefix' => 1,
      'pattern' => "(?:2(?:0[1-35-9]|1[02-9]|2[03-589]|3[149]|4[08]|5[1-46]|6[0279]|7[0269]|8[13])|3(?:0[1-57-9]|1[02-9]|2[0135]|3[0-24679]|4[67]|5[12]|6[014]|8[056])|4(?:0[124-9]|1[02-579]|2[3-5]|3[0245]|4[0235]|58|6[39]|7[0589]|8[04])|5(?:0[1-57-9]|1[0235-8]|20|3[0149]|4[01]|5[19]|6[1-47]|7[013-5]|8[056])|6(?:0[1-35-9]|1[024-9]|2[03689]|[34][016]|5[017]|6[0-279]|78|8[0-2])|7(?:0[1-46-8]|1[2-9]|2[04-7]|3[1247]|4[037]|5[47]|6[02359]|7[02-59]|8[156])|8(?:0[1-68]|1[02-8]|2[08]|3[0-28]|4[3578]|5[046-9]|6[02-5]|7[028])|9(?:0[1346-9]|1[02-9]|2[0589]|3[0146-8]|4[0179]|5[12469]|7[0-389]|8[04-69]))[2-9]\d{6}",
      'country_code' => "US",
      'example' => "2015550123",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Uruguay",
      'prefix' => 598,
      'pattern' => "9[1-9]\d{6}",
      'country_code' => "UY",
      'example' => "94231234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Uzbekistan",
      'prefix' => 998,
      'pattern' => "(?:6(?:1(?:2(?:2[01]|98)|35[0-4]|50\d|61[23]|7(?:[01][017]|4\d|55|9[5-9]))|2(?:(?:11|7\d)\d|2(?:[12]1|9[01379])|5(?:[126]\d|3[0-4]))|5(?:19[01]|2(?:27|9[26])|(?:30|59|7\d)\d)|6(?:2(?:1[5-9]|2[0367]|38|41|52|60)|(?:3[79]|9[0-3])\d|4(?:56|83)|7(?:[07]\d|1[017]|3[07]|4[047]|5[057]|67|8[0178]|9[79]))|7(?:2(?:24|3[237]|4[5-9]|7[15-8])|5(?:7[12]|8[0589])|7(?:0\d|[39][07])|9(?:0\d|7[079]))|9(?:2(?:1[1267]|3[01]|5\d|7[0-4])|(?:5[67]|7\d)\d|6(?:2[0-26]|8\d)))|7(?:0\d{3}|1(?:13[01]|6(?:0[47]|1[67]|66)|71[3-69]|98\d)|2(?:2(?:2[79]|95)|3(?:2[5-9]|6[0-6])|57\d|7(?:0\d|1[17]|2[27]|3[37]|44|5[057]|66|88))|3(?:2(?:1[0-6]|21|3[469]|7[159])|(?:33|9[4-6])\d|5(?:0[0-4]|5[579]|9\d)|7(?:[0-3579]\d|4[0467]|6[67]|8[078]))|4(?:2(?:29|5[0257]|6[0-7]|7[1-57])|5(?:1[0-4]|8\d|9[5-9])|7(?:0\d|1[024589]|2[0-27]|3[0137]|[46][07]|5[01]|7[5-9]|9[079])|9(?:7[015-9]|[89]\d))|5(?:112|2(?:0\d|2[29]|[49]4)|3[1568]\d|52[6-9]|7(?:0[01578]|1[017]|[23]7|4[047]|[5-7]\d|8[78]|9[079]))|6(?:2(?:2[1245]|4[2-4])|39\d|41[179]|5(?:[349]\d|5[0-2])|7(?:0[017]|[13]\d|22|44|55|67|88))|9(?:22[128]|3(?:2[0-4]|7\d)|57[02569]|7(?:2[05-9]|3[37]|4\d|60|7[2579]|87|9[07])))|9[0-57-9]\d{3})\d{4}",
      'country_code' => "UZ",
      'example' => "912345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Vatican City",
      'prefix' => 39,
      'pattern' => "33\d{9}|3[1-9]\d{8}|3[2-9]\d{7}",
      'country_code' => "VA",
      'example' => "3123456789",
      'min_length' => 9,
      'max_length' => 11
    ],
    [
      'name' => "St. Vincent & Grenadines",
      'prefix' => 1,
      'pattern' => "784(?:4(?:3[0-5]|5[45]|89|9[0-8])|5(?:2[6-9]|3[0-4]))\d{4}",
      'country_code' => "VC",
      'example' => "7844301234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Venezuela",
      'prefix' => 58,
      'pattern' => "4(?:1[24-8]|2[46])\d{7}",
      'country_code' => "VE",
      'example' => "4121234567",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "British Virgin Islands",
      'prefix' => 1,
      'pattern' => "284(?:(?:3(?:0[0-3]|4[0-7]|68|9[34])|54[0-57])\d|4(?:(?:4[0-6]|68)\d|9(?:6[6-9]|9\d)))\d{3}",
      'country_code' => "VG",
      'example' => "2843001234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "U.S. Virgin Islands",
      'prefix' => 1,
      'pattern' => "340(?:2(?:01|2[06-8]|44|77)|3(?:32|44)|4(?:22|7[34])|5(?:1[34]|55)|6(?:26|4[23]|77|9[023])|7(?:1[2-57-9]|27|7\d)|884|998)\d{4}",
      'country_code' => "VI",
      'example' => "3406421234",
      'min_length' => 10,
      'max_length' => 10
    ],
    [
      'name' => "Vietnam",
      'prefix' => 84,
      'pattern' => "(?:(?:3\d|7[06-9])\d|5(?:2[238]|[689]\d)|8(?:[1-58]\d|6[5689]|9[689])|9(?:[0-8]\d|9[013-9]))\d{6}",
      'country_code' => "VN",
      'example' => "912345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Vanuatu",
      'prefix' => 678,
      'pattern' => "(?:5(?:[0-689]\d|7[2-5])|7[013-7]\d)\d{4}",
      'country_code' => "VU",
      'example' => "5912345",
      'min_length' => 7,
      'max_length' => 7
    ],
    [
      'name' => "Wallis & Futuna",
      'prefix' => 681,
      'pattern' => "(?:50|68|72|8[23])\d{4}",
      'country_code' => "WF",
      'example' => "501234",
      'min_length' => 6,
      'max_length' => 6
    ],
    [
      'name' => "Samoa",
      'prefix' => 685,
      'pattern' => "(?:7[25-7]|8(?:[3-7]|9\d{3}))\d{5}",
      'country_code' => "WS",
      'example' => "7212345",
      'min_length' => 7,
      'max_length' => 10
    ],
    [
      'name' => "Kosovo",
      'prefix' => 383,
      'pattern' => "4[3-79]\d{6}",
      'country_code' => "XK",
      'example' => "43201234",
      'min_length' => 8,
      'max_length' => 8
    ],
    [
      'name' => "Yemen",
      'prefix' => 967,
      'pattern' => "7[0137]\d{7}",
      'country_code' => "YE",
      'example' => "712345678",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Mayotte",
      'prefix' => 262,
      'pattern' => "639(?:0[0-79]|1[019]|[267]\d|3[09]|[45]0|9[04-79])\d{4}",
      'country_code' => "YT",
      'example' => "639012345",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "South Africa",
      'prefix' => 27,
      'pattern' => "(?:6\d|7[0-46-9]|8[1-5])\d{7}|8[1-4]\d{3,6}",
      'country_code' => "ZA",
      'example' => "711234567",
      'min_length' => 5,
      'max_length' => 9
    ],
    [
      'name' => "Zambia",
      'prefix' => 260,
      'pattern' => "(?:76|9[5-8])\d{7}",
      'country_code' => "ZM",
      'example' => "955123456",
      'min_length' => 9,
      'max_length' => 9
    ],
    [
      'name' => "Zimbabwe",
      'prefix' => 263,
      'pattern' => "(?:7(?:1\d|3[2-9]|7[1-9]|8[2-5])|8644)\d{6}",
      'country_code' => "ZW",
      'example' => "712345678",
      'min_length' => 9,
      'max_length' => 10
    ],
  ];

  private static function processPhone(string $phone): string {
    return preg_replace('/[^0-9]/i', '', $phone);
  }

  private static function checkPattern(array $row, string $phone): bool {
    return preg_match('/'.$row['pattern'].'/i', $phone);
  }

  private static function checkPrefix(array $row, string $phone): bool {
    $prefix = $row['prefix'];
    $prefix_len = strlen($prefix);
    $phone_prefix = (int)substr($phone, 0, $prefix_len);
    return $phone_prefix === $prefix;
  }

  private static function checkLength($row, $phone) {
    $prefix_len = strlen($row['prefix']);
    $min_length = $row['min_length'];
    $max_length = $row['max_length'];
    $phone = substr($phone, $prefix_len);
    $phone_len = strlen($phone);
    return $phone_len >= $min_length && $phone_len <= $max_length;
  }

  private static function getPhonePattern($phone) {
    $phone = self::processPhone($phone);
    if (!$phone) {
      return false;
    }
    foreach (self::PATTERNS as $row) {
      if (!self::checkPattern($row, $phone)) {
        continue;
      }
      if (!self::checkLength($row, $phone)) {
        continue;
      }
      if (!self::checkPrefix($row, $phone)) {
        continue;
      }
      return $row;
    }
    return null;
  }

  public static function validate(string $phone): ?string {
    $info = self::getPhonePattern($phone);
    if (!$info) {
      return null;
    }
    return self::processPhone($phone);
  }

  public static function getRandomPattern(): array {
    return self::PATTERNS[array_rand(self::PATTERNS)];
  }

  public static function getPatterns(): array {
    return self::PATTERNS;
  }
}
