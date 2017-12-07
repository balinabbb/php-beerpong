<?php

namespace AppBundle\Transformers;

use AppBundle\Entity\Result;

class ResultTransformer implements IDataTransformer {

    public function transform($data)
    {
        if (!($data instanceof Result)) {
            throw new \InvalidArgumentException("Data must be of type Result::class");
        }

        $result = array(
            'type' => 'result',
            'id' => $data->getId(),
            'team1Score' => $data->getTeam1score(),
            'team2Score' => $data->getTeam2score(),
            'team1Player1' => $data->getTeam1player1()->getName(),
            'team1Player2' => $data->getTeam1player2()->getName(),
            'team2Player1' => $data->getTeam2player1()->getName(),
            'team2Player2' => $data->getTeam2player2()->getName(),
        );

        return $result;
    }

}
