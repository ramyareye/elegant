<?php

namespace App\Listeners;

use Dingo\Api\Event\ResponseWasMorphed;

class AddFixPaginationWrapToResponse
{
    public function handle(ResponseWasMorphed $event)
    {
        if ($event->response->isSuccessful())
        {
            $data = $event->response->content();
            
            if (array_key_exists("meta",$data)) {

                $from = ( $data['meta']['pagination']['current_page'] - 1 )
                        * $data['meta']['pagination']['count'] + 1;
                $to = $data['meta']['pagination']['current_page']
                      * $data['meta']['pagination']['count'];

                $last_page = $data['meta']['pagination']['total'] 
                             / $data['meta']['pagination']['count'];

                $event->response->setContent(json_encode([
                    'meta' => [
                        'pagination' => [
                            "total" => $data['meta']['pagination']['total'],
                            "per_page" => $data['meta']['pagination']['count'],
                            "current_page" => $data['meta']['pagination']['current_page'],
                            "last_page" => (int) $last_page,
                            // "next_page_url" => $data['meta']['pagination']['links']['next'] || null,
                            // "prev_page_url" => $data['meta']['pagination']['links']['previous'] || null,
                            "from" => $from,
                            "to" => $to
                        ]                    
                    ],
                    'data' => $data['data']
                ]));
            }
        }
    }
}