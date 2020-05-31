<?php

namespace App\Controller;

use App\Form\TempTrackerFormType;
use App\Repository\TempTrackerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TempTrackerController
 *
 * @Route("/temp-tracker")
 *
 * @package App\Controller
 */
class TempTrackerController extends AbstractController
{
    /**
     * @Route("/", name="temp_tracker", methods={"GET", "POST"})
     */
    public function indexAction(EntityManagerInterface $em, TempTrackerRepository $tempTrackerRepository, Request $request)
    {
        $form = $this->createForm(TempTrackerFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $tempTracker = $form->getData();

                $em->persist($tempTracker);
                $em->flush();

                $this->addFlash('success', 'Temperature Saved.');

                return $this->redirectToRoute('temp_tracker');

        }

        $record = [];
        $highest = $tempTrackerRepository->getHighest();
        if ($highest) {
            $record['highest'] = $highest;
        }
        $lowest = $tempTrackerRepository->getLowest();
        if ($lowest) {
            $record['lowest'] = $lowest;
        }
        $average = $tempTrackerRepository->getAverage();
        if ($average) {
            $record['average'] = round($average, 2);
        }

        return $this->render('temp_tracker/index.html.twig', ['form' => $form->createView(), 'record' => $record]);
    }
}
