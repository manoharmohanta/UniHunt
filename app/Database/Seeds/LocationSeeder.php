<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $countries = [
            [
                'code' => 'USA',
                'name' => 'United States',
                'slug' => 'united-states',
                'currency' => 'USD',
                'living_cost_min' => 12000,
                'living_cost_max' => 20000,
                'gic_amount' => 0,
            ],
            [
                'code' => 'GBR',
                'name' => 'United Kingdom',
                'slug' => 'united-kingdom',
                'currency' => 'GBP',
                'living_cost_min' => 10000,
                'living_cost_max' => 15000,
                'gic_amount' => 0,
            ],
            [
                'code' => 'AUS',
                'name' => 'Australia',
                'slug' => 'australia',
                'currency' => 'AUD',
                'living_cost_min' => 15000,
                'living_cost_max' => 25000,
                'gic_amount' => 0,
            ],
            [
                'code' => 'CAN',
                'name' => 'Canada',
                'slug' => 'canada',
                'currency' => 'CAD',
                'living_cost_min' => 15000,
                'living_cost_max' => 20000,
                'gic_amount' => 20635, // Updated Canada GIC
            ],
            [
                'code' => 'NZL',
                'name' => 'New Zealand',
                'slug' => 'new-zealand',
                'currency' => 'NZD',
                'living_cost_min' => 18000,
                'living_cost_max' => 22000,
                'gic_amount' => 0,
            ],
            [
                'code' => 'IRL',
                'name' => 'Ireland',
                'slug' => 'ireland',
                'currency' => 'EUR',
                'living_cost_min' => 10000,
                'living_cost_max' => 12000,
                'gic_amount' => 0,
            ],
            [
                'code' => 'DEU',
                'name' => 'Germany',
                'slug' => 'germany',
                'currency' => 'EUR',
                'living_cost_min' => 10000,
                'living_cost_max' => 11208, // Blocked account amount
                'gic_amount' => 0,
            ],
            [
                'code' => 'ARE',
                'name' => 'United Arab Emirates',
                'slug' => 'united-arab-emirates',
                'currency' => 'AED',
                'living_cost_min' => 30000,
                'living_cost_max' => 50000,
                'gic_amount' => 0,
            ],
            [
                'code' => 'SGP',
                'name' => 'Singapore',
                'slug' => 'singapore',
                'currency' => 'SGD',
                'living_cost_min' => 12000,
                'living_cost_max' => 24000,
                'gic_amount' => 0,
            ],
        ];

        foreach ($countries as $country) {
            $this->db->table('countries')->ignore(true)->insert($country);
            $countryId = $this->db->insertID();

            if (!$countryId) {
                // Fetch existing country ID if insert failed due to duplicate code
                $existingCountry = $this->db->table('countries')->where('code', $country['code'])->get()->getRow();
                $countryId = $existingCountry->id;
            }

            // Seed States and Cities based on country
            $this->seedDetails($countryId, $country['code']);
        }
    }

    protected function seedDetails($countryId, $countryCode)
    {
        $details = [
            'USA' => [
                'states' => [
                    'Alabama',
                    'Alaska',
                    'Arizona',
                    'Arkansas',
                    'California',
                    'Colorado',
                    'Connecticut',
                    'Delaware',
                    'Florida',
                    'Georgia',
                    'Hawaii',
                    'Idaho',
                    'Illinois',
                    'Indiana',
                    'Iowa',
                    'Kansas',
                    'Kentucky',
                    'Louisiana',
                    'Maine',
                    'Maryland',
                    'Massachusetts',
                    'Michigan',
                    'Minnesota',
                    'Mississippi',
                    'Missouri',
                    'Montana',
                    'Nebraska',
                    'Nevada',
                    'New Hampshire',
                    'New Jersey',
                    'New Mexico',
                    'New York',
                    'North Carolina',
                    'North Dakota',
                    'Ohio',
                    'Oklahoma',
                    'Oregon',
                    'Pennsylvania',
                    'Rhode Island',
                    'South Carolina',
                    'South Dakota',
                    'Tennessee',
                    'Texas',
                    'Utah',
                    'Vermont',
                    'Virginia',
                    'Washington',
                    'West Virginia',
                    'Wisconsin',
                    'Wyoming'
                ],
                'cities' => [
                    ['name' => 'New York City', 'cost' => 2500],
                    ['name' => 'Los Angeles', 'cost' => 2200],
                    ['name' => 'Chicago', 'cost' => 1800],
                    ['name' => 'Houston', 'cost' => 1600],
                    ['name' => 'Phoenix', 'cost' => 1500],
                    ['name' => 'Philadelphia', 'cost' => 1700],
                    ['name' => 'San Antonio', 'cost' => 1400],
                    ['name' => 'San Diego', 'cost' => 2100],
                    ['name' => 'Dallas', 'cost' => 1600],
                    ['name' => 'San Jose', 'cost' => 2400],
                    ['name' => 'Austin', 'cost' => 1800],
                    ['name' => 'Jacksonville', 'cost' => 1400],
                    ['name' => 'Fort Worth', 'cost' => 1400],
                    ['name' => 'Columbus', 'cost' => 1400],
                    ['name' => 'Charlotte', 'cost' => 1500],
                    ['name' => 'San Francisco', 'cost' => 3000],
                    ['name' => 'Indianapolis', 'cost' => 1300],
                    ['name' => 'Seattle', 'cost' => 2200],
                    ['name' => 'Denver', 'cost' => 1800],
                    ['name' => 'Washington D.C.', 'cost' => 2300],
                ]
            ],
            'GBR' => [
                'states' => ['England', 'Scotland', 'Wales', 'Northern Ireland'],
                'cities' => [
                    ['name' => 'London', 'cost' => 1800],
                    ['name' => 'Birmingham', 'cost' => 1100],
                    ['name' => 'Manchester', 'cost' => 1100],
                    ['name' => 'Glasgow', 'cost' => 1000],
                    ['name' => 'Newcastle', 'cost' => 900],
                    ['name' => 'Sheffield', 'cost' => 900],
                    ['name' => 'Liverpool', 'cost' => 950],
                    ['name' => 'Leeds', 'cost' => 1000],
                    ['name' => 'Bristol', 'cost' => 1200],
                    ['name' => 'Nottingham', 'cost' => 950],
                    ['name' => 'Edinburgh', 'cost' => 1200],
                    ['name' => 'Leicester', 'cost' => 900],
                    ['name' => 'Coventry', 'cost' => 900],
                    ['name' => 'Belfast', 'cost' => 950],
                    ['name' => 'Cardiff', 'cost' => 1000],
                    ['name' => 'Reading', 'cost' => 1200],
                    ['name' => 'Southampton', 'cost' => 1050],
                    ['name' => 'Aberdeen', 'cost' => 1000],
                    ['name' => 'Plymouth', 'cost' => 900],
                    ['name' => 'Stoke-on-Trent', 'cost' => 850],
                ]
            ],
            'AUS' => [
                'states' => ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Tasmania', 'Australian Capital Territory', 'Northern Territory'],
                'cities' => [
                    ['name' => 'Sydney', 'cost' => 2400],
                    ['name' => 'Melbourne', 'cost' => 2200],
                    ['name' => 'Brisbane', 'cost' => 1800],
                    ['name' => 'Perth', 'cost' => 1800],
                    ['name' => 'Adelaide', 'cost' => 1600],
                    ['name' => 'Gold Coast', 'cost' => 1700],
                    ['name' => 'Canberra', 'cost' => 1900],
                    ['name' => 'Newcastle', 'cost' => 1500],
                    ['name' => 'Wollongong', 'cost' => 1500],
                    ['name' => 'Sunshine Coast', 'cost' => 1600],
                    ['name' => 'Hobart', 'cost' => 1500],
                    ['name' => 'Geelong', 'cost' => 1500],
                    ['name' => 'Townsville', 'cost' => 1400],
                    ['name' => 'Cairns', 'cost' => 1400],
                    ['name' => 'Darwin', 'cost' => 1700],
                    ['name' => 'Toowoomba', 'cost' => 1300],
                    ['name' => 'Ballarat', 'cost' => 1300],
                    ['name' => 'Bendigo', 'cost' => 1300],
                    ['name' => 'Albury', 'cost' => 1200],
                    ['name' => 'Launceston', 'cost' => 1300],
                ]
            ],
            'CAN' => [
                'states' => ['Ontario', 'British Columbia', 'Quebec', 'Alberta', 'Manitoba', 'Saskatchewan', 'Nova Scotia', 'New Brunswick', 'Newfoundland and Labrador', 'Prince Edward Island'],
                'cities' => [
                    ['name' => 'Toronto', 'cost' => 2300],
                    ['name' => 'Montreal', 'cost' => 1600],
                    ['name' => 'Vancouver', 'cost' => 2400],
                    ['name' => 'Calgary', 'cost' => 1700],
                    ['name' => 'Edmonton', 'cost' => 1500],
                    ['name' => 'Ottawa', 'cost' => 1800],
                    ['name' => 'Winnipeg', 'cost' => 1300],
                    ['name' => 'Quebec City', 'cost' => 1400],
                    ['name' => 'Hamilton', 'cost' => 1600],
                    ['name' => 'Kitchener', 'cost' => 1600],
                    ['name' => 'London', 'cost' => 1500],
                    ['name' => 'Victoria', 'cost' => 1800],
                    ['name' => 'Halifax', 'cost' => 1500],
                    ['name' => 'Oshawa', 'cost' => 1600],
                    ['name' => 'Windsor', 'cost' => 1300],
                    ['name' => 'Saskatoon', 'cost' => 1400],
                    ['name' => 'Regina', 'cost' => 1300],
                    ['name' => 'St. John\'s', 'cost' => 1300],
                    ['name' => 'Kelowna', 'cost' => 1700],
                    ['name' => 'Barrie', 'cost' => 1600],
                ]
            ],
            'NZL' => [
                'states' => ['Auckland', 'Wellington', 'Canterbury', 'Waikato', 'Bay of Plenty', 'Otago', 'Manawatu-Wanganui', 'Northland', 'Taranaki', 'Hawke\'s Bay', 'Southland', 'Nelson', 'Gisborne', 'Marlborough', 'West Coast'],
                'cities' => [
                    ['name' => 'Auckland', 'cost' => 2200],
                    ['name' => 'Wellington', 'cost' => 2000],
                    ['name' => 'Christchurch', 'cost' => 1700],
                    ['name' => 'Hamilton', 'cost' => 1600],
                    ['name' => 'Tauranga', 'cost' => 1700],
                    ['name' => 'Lower Hutt', 'cost' => 1700],
                    ['name' => 'Dunedin', 'cost' => 1500],
                    ['name' => 'Palmerston North', 'cost' => 1400],
                    ['name' => 'Napier', 'cost' => 1400],
                    ['name' => 'Porirua', 'cost' => 1600],
                    ['name' => 'New Plymouth', 'cost' => 1500],
                    ['name' => 'Rotorua', 'cost' => 1400],
                    ['name' => 'Whangarei', 'cost' => 1400],
                    ['name' => 'Nelson', 'cost' => 1500],
                    ['name' => 'Invercargill', 'cost' => 1300],
                    ['name' => 'Upper Hutt', 'cost' => 1500],
                    ['name' => 'Whanganui', 'cost' => 1300],
                    ['name' => 'Gisborne', 'cost' => 1300],
                    ['name' => 'Hastings', 'cost' => 1400],
                    ['name' => 'Timaru', 'cost' => 1300],
                ]
            ],
            'IRL' => [
                'states' => ['Leinster', 'Munster', 'Connacht', 'Ulster (Part)'],
                'cities' => [
                    ['name' => 'Dublin', 'cost' => 2000],
                    ['name' => 'Cork', 'cost' => 1500],
                    ['name' => 'Limerick', 'cost' => 1300],
                    ['name' => 'Galway', 'cost' => 1400],
                    ['name' => 'Waterford', 'cost' => 1200],
                    ['name' => 'Drogheda', 'cost' => 1300],
                    ['name' => 'Swords', 'cost' => 1600],
                    ['name' => 'Dundalk', 'cost' => 1200],
                    ['name' => 'Bray', 'cost' => 1500],
                    ['name' => 'Navan', 'cost' => 1300],
                    ['name' => 'Ennis', 'cost' => 1100],
                    ['name' => 'Kilkenny', 'cost' => 1200],
                    ['name' => 'Tralee', 'cost' => 1100],
                    ['name' => 'Carlow', 'cost' => 1100],
                    ['name' => 'Newbridge', 'cost' => 1300],
                    ['name' => 'Portlaoise', 'cost' => 1100],
                    ['name' => 'Mullingar', 'cost' => 1200],
                    ['name' => 'Wexford', 'cost' => 1100],
                    ['name' => 'Letterkenny', 'cost' => 1000],
                    ['name' => 'Athlone', 'cost' => 1100],
                ]
            ],
            'DEU' => [
                'states' => [
                    'Baden-Württemberg',
                    'Bavaria',
                    'Berlin',
                    'Brandenburg',
                    'Bremen',
                    'Hamburg',
                    'Hesse',
                    'Lower Saxony',
                    'Mecklenburg-Western Pomerania',
                    'North Rhine-Westphalia',
                    'Rhineland-Palatinate',
                    'Saarland',
                    'Saxony',
                    'Saxony-Anhalt',
                    'Schleswig-Holstein',
                    'Thuringia'
                ],
                'cities' => [
                    ['name' => 'Berlin', 'cost' => 1100],
                    ['name' => 'Hamburg', 'cost' => 1150],
                    ['name' => 'Munich', 'cost' => 1300],
                    ['name' => 'Cologne', 'cost' => 1050],
                    ['name' => 'Frankfurt', 'cost' => 1150],
                    ['name' => 'Stuttgart', 'cost' => 1100],
                    ['name' => 'Düsseldorf', 'cost' => 1050],
                    ['name' => 'Dortmund', 'cost' => 950],
                    ['name' => 'Essen', 'cost' => 950],
                    ['name' => 'Leipzig', 'cost' => 900],
                    ['name' => 'Bremen', 'cost' => 950],
                    ['name' => 'Dresden', 'cost' => 900],
                    ['name' => 'Hanover', 'cost' => 1000],
                    ['name' => 'Nuremberg', 'cost' => 1000],
                    ['name' => 'Duisburg', 'cost' => 900],
                    ['name' => 'Bochum', 'cost' => 900],
                    ['name' => 'Wuppertal', 'cost' => 900],
                    ['name' => 'Bielefeld', 'cost' => 900],
                    ['name' => 'Bonn', 'cost' => 1050],
                    ['name' => 'Münster', 'cost' => 1000],
                ]
            ],
            'ARE' => [
                'states' => ['Abu Dhabi', 'Dubai', 'Sharjah', 'Ajman', 'Umm Al Quwain', 'Ras Al Khaimah', 'Fujairah'],
                'cities' => [
                    ['name' => 'Dubai', 'cost' => 4500],
                    ['name' => 'Abu Dhabi', 'cost' => 4500],
                    ['name' => 'Sharjah', 'cost' => 3000],
                    ['name' => 'Al Ain', 'cost' => 3000],
                    ['name' => 'Ajman', 'cost' => 2500],
                    ['name' => 'Ras Al Khaimah', 'cost' => 2500],
                    ['name' => 'Fujairah', 'cost' => 2500],
                    ['name' => 'Umm Al Quwain', 'cost' => 2200],
                    ['name' => 'Khor Fakkan', 'cost' => 2200],
                    ['name' => 'Kalba', 'cost' => 2200],
                    ['name' => 'Jebel Ali', 'cost' => 3500],
                    ['name' => 'Madinat Zayed', 'cost' => 2000],
                    ['name' => 'Ruwais', 'cost' => 2000],
                    ['name' => 'Liwa Oasis', 'cost' => 1800],
                    ['name' => 'Dhaid', 'cost' => 1800],
                    ['name' => 'Hatta', 'cost' => 1800],
                    ['name' => 'Dibba Al-Hisn', 'cost' => 2000],
                ]
            ],
            'SGP' => [
                'states' => ['Central Region', 'East Region', 'North Region', 'North-East Region', 'West Region'],
                'cities' => [
                    ['name' => 'Singapore Orchard', 'cost' => 3500],
                    ['name' => 'Jurong East', 'cost' => 2800],
                    ['name' => 'Tampines', 'cost' => 2800],
                    ['name' => 'Woodlands', 'cost' => 2500],
                    ['name' => 'Bedok', 'cost' => 2600],
                    ['name' => 'Choa Chu Kang', 'cost' => 2500],
                    ['name' => 'Hougang', 'cost' => 2600],
                    ['name' => 'Ang Mo Kio', 'cost' => 2700],
                    ['name' => 'Yishun', 'cost' => 2500],
                    ['name' => 'Bukit Batok', 'cost' => 2600],
                    ['name' => 'Sengkang', 'cost' => 2600],
                    ['name' => 'Serangoon', 'cost' => 2800],
                    ['name' => 'Geylang', 'cost' => 2800],
                    ['name' => 'Clementi', 'cost' => 2900],
                    ['name' => 'Bukit Panjang', 'cost' => 2500],
                    ['name' => 'Queenstown', 'cost' => 3000],
                    ['name' => 'Pasir Ris', 'cost' => 2700],
                    ['name' => 'Bishan', 'cost' => 3000],
                    ['name' => 'Marine Parade', 'cost' => 3200],
                    ['name' => 'Toa Payoh', 'cost' => 2800],
                ]
            ],
        ];

        if (isset($details[$countryCode])) {
            foreach ($details[$countryCode]['states'] as $stateName) {
                $this->db->table('states')->ignore(true)->insert([
                    'country_id' => $countryId,
                    'name' => $stateName
                ]);
            }

            foreach ($details[$countryCode]['cities'] as $city) {
                $this->db->table('cities')->ignore(true)->insert([
                    'country_id' => $countryId,
                    'name' => $city['name'],
                    'living_cost' => $city['cost']
                ]);
            }
        }
    }
}
