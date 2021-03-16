<?php


class leads
{
    public $return = [
        "leads" => [
            "status" => [
                "title" => [
                    1 => 'Active',
                    2 => 'Close',
                ],
                "value" => [
                    'active' => '1',
                    'close' => '2',
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