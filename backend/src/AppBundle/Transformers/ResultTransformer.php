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
        );

        return $result;
    }

}
