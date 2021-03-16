<?php


class leads
{
    public $return = [
        "leads" => [
            "status" => [
                "title" => [
                    1 => 'New',
                    2 => 'Active',
                    3 => 'Open',
                    4 => 'In progress',
                    5 => 'Open deal',
                    6 => 'Unqualified',
                    7 => 'Attempted to contact',
                    8 => 'Connected',
                    9 => 'Bad timing',
                    10 => 'Close',
                ],
                "value" => [
                    'new' => '1',
                    'active' => '2',
                    'open' => '3',
                    'in_progress' => '4',
                    'open_deal' => '5',
                    'unqualified' => '6',
                    'attempted_to_contact' => '7',
                    'connected' => '8',
                    'bad_timing' => '9',
                    'close' => '10',
                ]
            ]
        ],
    ];

    /**
     * @return array
     */
    /**
     * @return array
     */
    public function getArray()
    {
        return $this->return;
    }

}

?>