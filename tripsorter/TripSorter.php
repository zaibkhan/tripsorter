<?php
/**
 * Class TripSorter
 */
class TripSorter
{        
    /**
     * The cards
     *
     * @var array
     */
    public $cards = [
        [
            "Departure"             => "Gerona Airport",
            "Arrival"               => "Stockholm",
            "Transportation"        => "Plane",
            "Transportation_number" => "SK455",
            "Seat"                  => "3A",
            "Gate"                  => "45B",
            "Baggage"               => "334",
        ],
        [
            "Departure"             => "Stockholm",
            "Arrival"               => "New York",
            "Transportation"        => "Plane",
            "Transportation_number" => "SK22",
            "Seat"                  => "7B",
            "Gate"                  => "22",
        ],
        [
            "Departure"      => "Barcelona",
            "Arrival"        => "Gerona Airport",
            "Transportation" => "Bus",
        ],
        [
            "Departure"             => "Madrid",
            "Arrival"               => "Barcelona",
            "Transportation"        => "Train",
            "Transportation_number" => "78A",
            "Seat"                  => "45B",
        ],
    ];    
    
    /**
     * constructor
     *
     * @param array $cards
     */
    public function __construct($cards = [])
    {
        if (!empty($cards)) {
            $this->cards = $cards;
        }
    }
    
    /**
     * get cards
     *
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }
    
    /**
     * start my trip
     *
     * @return HTML
     */
    public function startMyTrip()
    {
        $cardsArray = $this->getCards();
        $totalCards = count($cardsArray);        

        $sorted_cards = $this->recursiveSort($cardsArray, $totalCards, 0);
        //echo '<pre>';print_r($sorted_cards);exit;
        
        $html = $this->outputHtml($sorted_cards);                
        return $html;
    }
    
    /**
     * @param $cardsArray
     * @param $totalCards
     * @param $startIndex
     *
     * @return $cardsArray
     */
    private function recursiveSort($cardsArray, $totalCards, $startIndex = 0)
    {
        if ($startIndex == $totalCards - 1) {
            return $cardsArray;
        }
        
        for ($i = $startIndex; $i < $totalCards; $i++) {
            for ($k = $i + 1; $k < $totalCards; $k++) {
                if ($cardsArray[$i]['Departure'] == $cardsArray[$k]['Arrival']) {
                    $cardsArray = $this->swapIndexes($cardsArray, $i, $k);
                    
                    return $this->recursiveSort($cardsArray, $totalCards, $i);
                }
            }
        }
        
        return $cardsArray;
    }
    
    /**
     * @param $cardsArray
     * @param $i
     * @param $k
     *
     * @return $cardsArray
     */
    private function swapIndexes($cardsArray, $i, $k)
    {
        $temp           = $cardsArray[$i];
        $cardsArray[$i] = $cardsArray[$k];
        $cardsArray[$k] = $temp;
        
        return $cardsArray;
    }
    
    /**
     * out put html
     *
     * @return html
     */
    public function outputHtml($cards = array())
    {
        $html = "<ol>";        
        foreach ($cards as $card) {            
            $html .= "<li>Take ".$card['Transportation'].' From '.$card['Departure'].' to '.$card['Arrival'].'. ';
            $html .= (!empty($card['Seat']))?'Your Seat #: '.$card['Seat']:'no seat assignment.';
            $html .= (!empty($card['Gate']))?', Gate #: '.$card['Gate']:'';
            $html .= (!empty($card['Baggage']))?', Baggage counter #: '.$card['Baggage']:'';
            $html .= '</li>';
            
            //last, final destination
            if ($card === end($cards)) {
                $html .= '<li>You have arrived at your final destination</li>';
            }
        }
        $html .= "</ol>";
        
        return $html;
    }
}