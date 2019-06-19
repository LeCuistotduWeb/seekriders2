<?php
namespace App\Service;
use App\Entity\Session;

/**
 * Class SessionService
 * @package App\Service
 */
class SessionService
{
    /**
     * @param $startDate
     * @return bool
     */
    public function startDateIsValid ($startDate){
        $today = new \DateTime();
        if ($startDate >= $today){
            return true;
        };
        return false;
    }

    /**
     * @param Session $session
     * @return bool
     */
    public function endDateIsValid (Session $session)
    {
        $startDate = $session->getStartDateAt();
        $endDate = $session->getEndDateAt();
        $today = new \DateTime();
        if (($startDate >= $today) && ($endDate >= $startDate)){
            return true;
        };
        return false;
    }
}